<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\DoctorLayout;
use App\Models\DoctorPatients;
use App\Models\PatientReport;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\PatientDomainReport;
use App\Models\ReportAnswer;
use App\Models\AppointmentAnswer;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

#[Layout(DoctorLayout::class)]
class DoctorReportsList extends Component
{
    use Interactions;

    public $expandedPatient = null;
    public $selectedReport = null;
    public $reportType = null; // 'daily', 'fiqr', 'appointment'
    public $showModal = false;
    public $medication = ''; // Campo para medicamentos prescritos

    public function togglePatient($patientId)
    {
        if ($this->expandedPatient === $patientId) {
            $this->expandedPatient = null;
        } else {
            $this->expandedPatient = $patientId;
        }
    }

    public function openReportModal($reportId, $type)
    {
        $this->selectedReport = $reportId;
        $this->reportType = $type;
        $this->showModal = true;
        
        // Load medication if it's a report (daily or fiqr)
        if ($type === 'daily' || $type === 'fiqr') {
            $report = PatientReport::where('par_id', $reportId)->first();
            $this->medication = $report ? ($report->par_medication ?? '') : '';
        } else {
            $this->medication = '';
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReport = null;
        $this->reportType = null;
        $this->medication = '';
    }

    public function saveMedication()
    {
        // Only allow saving for daily and fiqr reports
        if (!in_array($this->reportType, ['daily', 'fiqr']) || !$this->selectedReport) {
            $this->toast()->error('Não é possível salvar medicamentos para este tipo de registro.')->send();
            return;
        }

        try {
            $report = PatientReport::where('par_id', $this->selectedReport)->first();
            
            if (!$report) {
                $this->toast()->error('Registro não encontrado.')->send();
                return;
            }

            $report->update([
                'par_medication' => $this->medication
            ]);

            $this->toast()->success('Medicamentos salvos com sucesso!')->send();
        } catch (\Exception $e) {
            $this->toast()->error('Erro ao salvar medicamentos: ' . $e->getMessage())->send();
        }
    }

    public function render()
    {
        $doctorId = Auth::user()->usr_represented_agent;
        
        // Get all linked patients
        $doctorPatients = DoctorPatients::where('doctor_doc_id', $doctorId)
            ->where('dop_status', DoctorPatients::STATUS_LINKED)
            ->with([
                'patient.user',
                'patient.patientReports' => function($query) {
                    $query->orderBy('par_period_starts', 'desc');
                },
                'patient.appointments' => function($query) {
                    $query->orderBy('app_date', 'desc');
                }
            ])
            ->get();

        // Load detailed report data for modal if selected
        $reportData = null;
        $domainScores = [];
        
        if ($this->selectedReport && $this->reportType) {
            if ($this->reportType === 'daily') {
                $reportData = PatientReport::where('par_id', $this->selectedReport)
                    ->where('par_type', PatientReport::TYPE_DAILY)
                    ->with('patientDomainReports.reportAnswers.question')
                    ->first();
            } elseif ($this->reportType === 'fiqr') {
                // Load report following the same pattern as PatientFiqrReportForm
                $reportData = PatientReport::where('par_id', $this->selectedReport)
                    ->where('par_type', PatientReport::TYPE_FIQR)
                    ->with('patientDomainReports')
                    ->first();
                
                // Load reportAnswers with questions for each domain report
                if ($reportData && $reportData->patientDomainReports) {
                    $reportData->patientDomainReports->load('reportAnswers.question');
                    
                    // Prepare domain scores for display
                    $domainNames = [
                        'first_domain' => 'Função Física',
                        'second_domain' => 'Impacto Geral',
                        'third_domain' => 'Sintomas'
                    ];
                    
                    foreach ($reportData->patientDomainReports as $domainReport) {
                        $domainKey = $this->getDomainKey($domainReport->pdr_domain);
                        if ($domainKey) {
                            $domainScores[$domainKey] = [
                                'name' => $domainNames[$domainReport->pdr_domain] ?? '',
                                'score' => $domainReport->pdr_score ?? 0
                            ];
                        }
                    }
                }
            } elseif ($this->reportType === 'appointment') {
                $reportData = Appointment::where('app_id', $this->selectedReport)
                    ->with('appointmentAnswers.question')
                    ->first();
            }
        }

        return view('livewire.doctor.doctor-reports-list', [
            'doctorPatients' => $doctorPatients,
            'reportData' => $reportData,
            'domainScores' => $domainScores
        ]);
    }

    private function getDomainKey($domain)
    {
        $domainMap = [
            PatientDomainReport::DOMAIN_FIRST => 'first',
            PatientDomainReport::DOMAIN_SECOND => 'second',
            PatientDomainReport::DOMAIN_THIRD => 'third',
        ];
        
        return $domainMap[$domain] ?? null;
    }
}
