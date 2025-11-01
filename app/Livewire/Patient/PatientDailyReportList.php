<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\ReportsTrait;
use App\View\Components\Layouts\PatientLayout;

#[Layout(PatientLayout::class)]
class PatientDailyReportList extends Component
{
    use ReportsTrait;

    public function redirectToDailyReportForm() {
        return redirect()->route('patient.daily-report-form');
    }

    public function viewReport($reportId) {
        return redirect()->route('patient.daily-report-form', ['id' => $reportId]);
    }

    public function render()
    {
        return view('livewire.patient.patient-daily-report-list', [
            'dailyReports' => $this->getLatestDailyReports(),
            'todayReport' => $this->getTodayDailyReport()
        ]);
    }
}
