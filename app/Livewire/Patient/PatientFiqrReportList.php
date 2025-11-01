<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\ReportsTrait;
use App\View\Components\Layouts\PatientLayout;

#[Layout(PatientLayout::class)]
class PatientFiqrReportList extends Component
{
    use ReportsTrait;

    public function viewReportDay($reportId, $weekday) {
        return redirect()->route('patient.fiqr-report-form', ['id' => $reportId, 'weekday' => $weekday]);
    }

    public function render()
    {
        $currentFiqrReport = $this->getCurrentFiqrReport();
        
        return view('livewire.patient.patient-fiqr-report-list', [
            'fiqrReports' => $this->getLatestFiqrReports(),
            'currentFiqrReport' => $currentFiqrReport,
            'weekDays' => $this->getWeekDays(),
            'dayStatuses' => $this->getFiqrDayStatuses($currentFiqrReport)
        ]);
    }
}
