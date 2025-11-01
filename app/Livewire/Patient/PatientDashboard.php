<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientReport;
use App\Models\Appointment;
use App\Models\Question;
use App\Models\ReportAnswer;
use App\Http\Controllers\dao\GenericCtrl;
use Illuminate\Support\Facades\Auth;
use App\View\Components\Layouts\PatientLayout;
use Carbon\Carbon;

#[Layout(PatientLayout::class)]
class PatientDashboard extends Component
{
    public function goToDailyReportList() {
        return redirect()->route('patient.daily-report');
    }

    public function goToFiqrReportList() {
        return redirect()->route('patient.fiqr-report');
    }

    public function goToAppointmentList() {
        return redirect()->route('patient.appointment-list');
    }

    public function render()
    {
        $patientId = Auth::user()->usr_represented_agent;

        // Count daily reports
        $dailyReportsCount = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->count();

        // Count FIQR reports
        $fiqrReportsCount = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->count();

        // Count appointments
        $appointmentsCount = Appointment::where('patient_pat_id', $patientId)
            ->count();

        $lastDailyReport = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->orderBy('par_id', 'desc')
            ->first();

        $lastDailyReportScore = $lastDailyReport ? ($lastDailyReport->par_score ?? 0) : 0;

        // Get last 7 daily reports for chart
        $last7DailyReports = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->orderBy('par_period_starts', 'desc')
            ->limit(7)
            ->with(['patientDomainReports.reportAnswers'])
            ->get();

        // Prepare chart data for total score
        $chartLabels = [];
        $chartData = [];
        $dayNames = [
            'Monday' => 'Segunda',
            'Tuesday' => 'Terça',
            'Wednesday' => 'Quarta',
            'Thursday' => 'Quinta',
            'Friday' => 'Sexta',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];

        // Reverse to show oldest first
        $reversedReports = $last7DailyReports->reverse();
        
        foreach ($reversedReports as $report) {
            $date = Carbon::parse($report->par_period_starts);
            $dayName = $dayNames[$date->format('l')] ?? $date->format('l');
            $chartLabels[] = $dayName;
            $chartData[] = $report->par_score ?? 0;
        }

        // Fill remaining slots with null if we have less than 7 reports
        $remainingSlots = 7 - count($chartLabels);
        for ($i = 0; $i < $remainingSlots; $i++) {
            $chartLabels[] = '';
            $chartData[] = null;
        }

        // Get daily report questions (excluding question 52)
        $questionCtrl = new GenericCtrl("Question");
        $dailyQuestions = $questionCtrl->getObjectByField("que_domain", Question::DOMAIN_MICRO_DAILY, false);
        $dailyQuestions = collect($dailyQuestions)->filter(function($question) {
            return $question->que_id != 52;
        })->values();

        // Prepare chart data for each question
        $questionCharts = [];
        
        foreach ($dailyQuestions as $question) {
            $questionData = [];
            
            // For each report, find the answer for this question
            foreach ($reversedReports as $report) {
                $answerValue = null;
                
                if ($report->patientDomainReports && $report->patientDomainReports->isNotEmpty()) {
                    $domainReport = $report->patientDomainReports->first();
                    
                    if ($domainReport->reportAnswers) {
                        $answer = $domainReport->reportAnswers->firstWhere('question_que_id', $question->que_id);
                        if ($answer) {
                            $answerValue = $answer->rea_value;
                        }
                    }
                }
                
                $questionData[] = $answerValue;
            }
            
            // Fill remaining slots with null if we have less than 7 reports
            $remainingSlotsQuestion = 7 - count($questionData);
            for ($i = 0; $i < $remainingSlotsQuestion; $i++) {
                $questionData[] = null;
            }
            
            $questionCharts[] = [
                'id' => $question->que_id,
                'name' => $question->que_name,
                'data' => $questionData,
            ];
        }

        return view('livewire.patient.patient-dashboard', [
            'dailyReportsCount' => $dailyReportsCount,
            'fiqrReportsCount' => $fiqrReportsCount,
            'appointmentsCount' => $appointmentsCount,
            'lastDailyReportScore' => $lastDailyReportScore,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'questionCharts' => $questionCharts,
        ]);
    }
}
