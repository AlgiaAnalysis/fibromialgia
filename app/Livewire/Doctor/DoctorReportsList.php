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

#[Layout(DoctorLayout::class)]
class DoctorReportsList extends Component
{
    public $expandedPatient = null;
    public $selectedReport = null;
    public $reportType = null; // 'daily', 'fiqr', 'appointment'
    public $showModal = false;

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
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedReport = null;
        $this->reportType = null;
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
        if ($this->selectedReport && $this->reportType) {
            if ($this->reportType === 'daily') {
                $reportData = PatientReport::where('par_id', $this->selectedReport)
                    ->where('par_type', PatientReport::TYPE_DAILY)
                    ->with('patientDomainReports.reportAnswers.question')
                    ->first();
            } elseif ($this->reportType === 'fiqr') {
                $reportData = PatientReport::where('par_id', $this->selectedReport)
                    ->where('par_type', PatientReport::TYPE_FIQR)
                    ->with('patientDomainReports.reportAnswers.question')
                    ->first();
            } elseif ($this->reportType === 'appointment') {
                $reportData = Appointment::where('app_id', $this->selectedReport)
                    ->with('appointmentAnswers.question')
                    ->first();
            }
        }

        return view('livewire.doctor.doctor-reports-list', [
            'doctorPatients' => $doctorPatients,
            'reportData' => $reportData
        ]);
    }
}
