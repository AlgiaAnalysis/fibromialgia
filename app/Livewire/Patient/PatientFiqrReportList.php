<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\ReportsTrait;
use App\Models\PatientReport;
use App\View\Components\Layouts\PatientLayout;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Layout(PatientLayout::class)]
class PatientFiqrReportList extends Component
{
    use ReportsTrait, Interactions;

    public function createNewFiqrReport() {
        // Check if user can create a new FIQR report (1 week restriction)
        $patientId = Auth::user()->usr_represented_agent;
        $lastFiqrReport = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->orderBy('par_period_starts', 'desc')
            ->first();
        
        if ($lastFiqrReport) {
            $lastReportDate = Carbon::parse($lastFiqrReport->par_period_starts);
            $daysSinceLastReport = $lastReportDate->diffInDays(now());
            
            if ($daysSinceLastReport < 7) {
                $daysRemaining = $daysSinceLastReport - 7;
                $this->toast()->error("Você só pode preencher um novo questionário FIQR após 7 dias. Faltam {$daysRemaining} dia(s).")->send();
                return;
            }
        }
        
        // Create new FIQR report
        $today = Carbon::now()->format('Y-m-d');
        
        $patientReport = PatientReport::create([
            'par_period_starts' => $today,
            'par_period_end' => $today,
            'par_status' => PatientReport::STATUS_PENDING,
            'par_medication' => '',
            'par_score' => 0,
            'par_cli_resume' => '',
            'par_type' => PatientReport::TYPE_FIQR,
            'patient_pat_id' => $patientId,
        ]);
        
        return redirect()->route('patient.fiqr-report-form', ['id' => $patientReport->par_id]);
    }

    public function viewFiqrReport($reportId) {
        return redirect()->route('patient.fiqr-report-form', ['id' => $reportId]);
    }

    public function render()
    {
        $patientId = Auth::user()->usr_represented_agent;
        $lastFiqrReport = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->where('par_status', PatientReport::STATUS_COMPLETED)
            ->orderBy('par_period_starts', 'desc')
            ->first();
        
        $canCreateNew = true;
        $daysRemaining = 0;
        
        if ($lastFiqrReport) {
            $lastReportDate = Carbon::parse($lastFiqrReport->par_period_end);
            $daysSinceLastReport = $lastReportDate->diffInDays(now());

            if ($daysSinceLastReport < 7) {
                $canCreateNew = false;
                $daysRemaining = $daysSinceLastReport - 7;
            }
        }
        
        return view('livewire.patient.patient-fiqr-report-list', [
            'fiqrReports' => $this->getLatestFiqrReports(),
            'canCreateNew' => $canCreateNew,
            'daysRemaining' => $daysRemaining,
            'lastFiqrReport' => $lastFiqrReport
        ]);
    }
}
