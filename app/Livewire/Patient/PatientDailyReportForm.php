<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Http\Controllers\dao\GenericCtrl;
use App\Models\Question;
use App\Models\PatientReport;
use App\Models\PatientDomainReport;
use App\Models\ReportAnswer;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.patient-layout')]
class PatientDailyReportForm extends Component
{
    use Interactions;

    public $questions = null;
    public $answers = [];
    public $reportId = null;
    public $existingReport = null;
    public $isViewMode = false;

    public function mount($id = null) {
        $questionCtrl = new GenericCtrl("Question");
        $this->questions = $questionCtrl->getObjectByField("que_domain", Question::DOMAIN_MICRO_DAILY, false);
        
        // Initialize answers array
        foreach ($this->questions as $question) {
            $this->answers[$question->que_id] = null;
        }

        // If viewing existing report
        if ($id) {
            $this->reportId = $id;
            $this->isViewMode = true;
            $this->loadExistingReport($id);
        }
    }

    private function loadExistingReport($reportId) {
        $this->existingReport = PatientReport::where('par_id', $reportId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->with('patientDomainReports.reportAnswers')
            ->first();

        if ($this->existingReport && $this->existingReport->patientDomainReports->isNotEmpty()) {
            $domainReport = $this->existingReport->patientDomainReports->first();
            
            // Load answers into the answers array
            foreach ($domainReport->reportAnswers as $answer) {
                $this->answers[$answer->question_que_id] = $answer->rea_value;
            }
        }
    }

    public function selectAnswer($questionId, $value) {
        $this->answers[$questionId] = $value;
    }

    public function submitForm() {
        // Validate that all questions are answered
        foreach ($this->answers as $questionId => $value) {
            if ($value === null) {
                $this->toast()->error('Por favor, responda todas as perguntas antes de enviar.')->send();
                return null;
            }
        }

        // Hard-coded patient ID as requested
        $patientId = Auth::user()->usr_represented_agent;
        $today = date('Y-m-d');

        // Create PatientReport
        $patientReport = PatientReport::create([
            'par_period_starts' => $today,
            'par_period_end' => $today, // Same date for daily reports
            'par_status' => PatientReport::STATUS_COMPLETED,
            'par_medication' => '',
            'par_score' => 0, // Empty score as requested
            'par_cli_resume' => '', // Empty AI resume as requested
            'par_type' => PatientReport::TYPE_DAILY,
            'patient_pat_id' => $patientId,
        ]);

        // Create PatientDomainReport
        $patientDomainReport = PatientDomainReport::create([
            'pdr_domain' => PatientDomainReport::DOMAIN_DAILY,
            'pdr_score' => 0, // Can be calculated later
            'patient_report_par_id' => $patientReport->par_id,
        ]);

        // Create ReportAnswers for each question
        foreach ($this->answers as $questionId => $value) {
            ReportAnswer::create([
                'rea_value' => $value,
                'rea_week_day' => '', // Empty for daily domain as requested
                'patient_domain_report_pdr_id' => $patientDomainReport->pdr_id,
                'question_que_id' => $questionId,
            ]);
        }

        $this->toast()->success('Questionário enviado com sucesso!')->send();
        return $this->redirect(route('patient.daily-report'));
    }

    public function goBack() {
        return $this->redirect(route('patient.daily-report'));
    }

    public function render()
    {
        return view('livewire.patient.patient-daily-report-form');
    }
}
