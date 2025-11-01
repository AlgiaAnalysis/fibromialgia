<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\DoctorLayout;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorPatients;
use App\Models\PatientReport;
use App\Models\PatientDomainReport;
use App\Models\ReportComparisons;
use App\Models\ReportsInComparisons;
use Carbon\Carbon;

#[Layout(DoctorLayout::class)]
class DoctorDashboard extends Component
{
    public $expandedPatientId = null;
    public $selectedPatientName = null;
    public $analysesList = []; // Lista de análises de IA
    public $selectedAnalysis = null; // Análise selecionada para modal
    public $showAnalysisModal = false;

    public function goToLinkPatient() {
        return redirect()->route('doctor.link-patient');
    }

    public function showAllEditions() {
        return redirect()->route('doctor.reports-list');
    }

    public function selectPatient($patientId)
    {
        $this->expandedPatientId = $patientId;
        $this->loadAnalyses($patientId);
    }

    public function openAnalysisModal($analysisId)
    {
        $this->selectedAnalysis = ReportComparisons::find($analysisId);
        $this->showAnalysisModal = true;
        $this->dispatch('analysisModalOpened');
    }

    public function closeAnalysisModal()
    {
        $this->showAnalysisModal = false;
        $this->selectedAnalysis = null;
    }

    private function loadAnalyses($patientId)
    {
        // Find selected patient name
        $doctorId = Auth::user()->usr_represented_agent;
        $doctorPatient = DoctorPatients::where('doctor_doc_id', $doctorId)
            ->where('patient_pat_id', $patientId)
            ->where('dop_status', DoctorPatients::STATUS_LINKED)
            ->with(['patient.user'])
            ->first();
        
        if ($doctorPatient && $doctorPatient->patient) {
            $this->selectedPatientName = $doctorPatient->patient->user->usr_name ?? 'Sem nome';
        } else {
            $this->selectedPatientName = null;
            $this->analysesList = [];
            return;
        }
        
        // Get all PatientReports for this patient
        $patientReports = PatientReport::where('patient_pat_id', $patientId)
            ->pluck('par_id')
            ->toArray();

        if (empty($patientReports)) {
            $this->analysesList = [];
            return;
        }

        // Get all ReportComparisons that include reports from this patient
        $comparisonIds = ReportsInComparisons::whereIn('patient_report_par_id', $patientReports)
            ->pluck('report_comparison_rec_id')
            ->unique()
            ->toArray();

        if (empty($comparisonIds)) {
            $this->analysesList = [];
            return;
        }

        // Load analyses with related reports to get dates
        $comparisons = ReportComparisons::whereIn('rec_id', $comparisonIds)
            ->orderBy('rec_id', 'desc')
            ->get();

        $this->analysesList = [];
        foreach ($comparisons as $comparison) {
            // Get the reports involved in this comparison
            $reportsInComparison = ReportsInComparisons::where('report_comparison_rec_id', $comparison->rec_id)
                ->with('patientReport')
                ->get();

            // Get the earliest and latest dates from the reports
            $dates = [];
            foreach ($reportsInComparison as $ric) {
                if ($ric->patientReport) {
                    $dates[] = $ric->patientReport->par_period_starts;
                }
            }

            $earliestDate = !empty($dates) ? min($dates) : null;
            $latestDate = !empty($dates) ? max($dates) : null;

            // Get preview (first 200 characters)
            $preview = $comparison->rec_ia_analysis ? substr($comparison->rec_ia_analysis, 0, 200) . '...' : '';

            $this->analysesList[] = [
                'id' => $comparison->rec_id,
                'preview' => $preview,
                'fullAnalysis' => $comparison->rec_ia_analysis ?? '',
                'earliestDate' => $earliestDate ? Carbon::parse($earliestDate)->format('d/m/Y') : 'N/A',
                'latestDate' => $latestDate ? Carbon::parse($latestDate)->format('d/m/Y') : 'N/A',
                'reportCount' => $reportsInComparison->count(),
            ];
        }
    }

    public function render()
    {
        $doctorId = Auth::user()->usr_represented_agent;

        // Get linked patients with their user data
        $doctorPatients = DoctorPatients::where('doctor_doc_id', $doctorId)
            ->where('dop_status', DoctorPatients::STATUS_LINKED)
            ->with(['patient.user'])
            ->get();

        // Get linked patients IDs
        $linkedPatientsIds = $doctorPatients->pluck('patient_pat_id')->toArray();

        // Count linked patients
        $doctorPatientsCount = count($linkedPatientsIds);

        // Count questionnaires from linked patients
        $questionnairesCount = PatientReport::whereIn('patient_pat_id', $linkedPatientsIds)
            ->count();

        // Prepare patients list with their last daily report score
        $patientsList = [];
        foreach ($doctorPatients as $doctorPatient) {
            $patient = $doctorPatient->patient;
            $lastDailyReport = PatientReport::where('patient_pat_id', $patient->pat_id)
                ->where('par_type', PatientReport::TYPE_DAILY)
                ->orderBy('par_period_starts', 'desc')
                ->first();
            
            $patientsList[] = [
                'id' => $patient->pat_id,
                'name' => $patient->user->usr_name ?? 'Sem nome',
                'email' => $patient->user->usr_email ?? '',
                'lastDailyScore' => $lastDailyReport ? ($lastDailyReport->par_score ?? 0) : null,
                'lastDailyDate' => $lastDailyReport ? $lastDailyReport->par_period_starts : null,
            ];
        }

        return view('livewire.doctor.doctor-dashboard', [
            'doctorPatientsCount' => $doctorPatientsCount,
            'questionnairesCount' => $questionnairesCount,
            'patientsList' => $patientsList,
        ]);
    }
}
