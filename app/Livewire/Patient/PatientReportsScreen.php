<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\ReportsTrait;
use App\View\Components\Layouts\PatientLayout;

#[Layout(PatientLayout::class)]
class PatientReportsScreen extends Component
{
    use ReportsTrait;

    public function redirectToDailyReportForm() {
        return redirect()->route('patient.daily-report-form');
    }

    public function viewDailyReport($reportId) {
        return redirect()->route('patient.daily-report-form', ['id' => $reportId]);
    }

    public function viewFiqrReportDay($reportId, $weekday) {
        return redirect()->route('patient.fiqr-report-form', ['id' => $reportId, 'weekday' => $weekday]);
    }

    public function redirectToAppointmentForm() {
        return redirect()->route('patient.appointment-form');
    }

    public function viewAppointment($appointmentId) {
        return redirect()->route('patient.appointment-form', ['id' => $appointmentId]);
    }

    public function render()
    {
        $currentFiqrReport = $this->getCurrentFiqrReport();
        
        return view('livewire.patient.patient-reports-screen', [
            'dailyReports' => $this->getLatestDailyReports(5),
            'todayDailyReport' => $this->getTodayDailyReport(),
            'fiqrReports' => $this->getLatestFiqrReports(5),
            'currentFiqrReport' => $currentFiqrReport,
            'appointments' => $this->getLatestAppointments(5),
            'todayAppointment' => $this->getTodayAppointment(),
            'weekDays' => $this->getWeekDays(),
            'dayStatuses' => $this->getFiqrDayStatuses($currentFiqrReport)
        ]);
    }
}
