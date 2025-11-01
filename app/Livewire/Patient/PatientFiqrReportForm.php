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
use App\View\Components\Layouts\PatientLayout;

#[Layout(PatientLayout::class)]
class PatientFiqrReportForm extends Component
{
    use Interactions;

    public $questionsByDomain = [];
    public $answers = [];
    public $reportId = null;
    public $weekday = null;
    public $existingReport = null;
    public $isViewMode = false;

    public function mount($id, $weekday) {
        $this->reportId = $id;
        $this->weekday = $weekday;
        
        $questionCtrl = new GenericCtrl("Question");
        
        // Load questions for all 3 FIQR domains
        $firstDomainQuestions = $questionCtrl->getObjectByField("que_domain", Question::DOMAIN_FIRST_DOMAIN, false);
        $secondDomainQuestions = $questionCtrl->getObjectByField("que_domain", Question::DOMAIN_SECOND_DOMAIN, false);
        $thirdDomainQuestions = $questionCtrl->getObjectByField("que_domain", Question::DOMAIN_THIRD_DOMAIN, false);

        $this->questionsByDomain = [
            'first' => [
                'name' => 'Função Física',
                'description' => 'Avalie sua capacidade física para realizar atividades do dia a dia.',
                'questions' => $firstDomainQuestions
            ],
            'second' => [
                'name' => 'Impacto Geral',
                'description' => 'Avalie o impacto geral da fibromialgia na sua vida na última semana.',
                'questions' => $secondDomainQuestions
            ],
            'third' => [
                'name' => 'Sintomas',
                'description' => 'Avalie os principais sintomas da fibromialgia (dor, disposição, rigidez e sono).',
                'questions' => $thirdDomainQuestions
            ]
        ];
        
        // Initialize answers array for each question
        foreach ($this->questionsByDomain as $domainKey => $domain) {
            foreach ($domain['questions'] as $question) {
                $this->answers[$domainKey][$question->que_id] = null;
            }
        }

        // Load existing report and answers
        $this->loadExistingReport();
    }

    private function loadExistingReport() {
        $this->existingReport = PatientReport::where('par_id', $this->reportId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->with(['patientDomainReports' => function($query) {
                $query->where('pdr_weekday', $this->weekday);
            }])
            ->first();

        if ($this->existingReport && $this->existingReport->patientDomainReports->isNotEmpty()) {
            // Check if already answered (completed)
            if ($this->existingReport->par_status === PatientReport::STATUS_COMPLETED) {
                $this->isViewMode = true;
            }

            // Load answers into the answers array
            foreach ($this->existingReport->patientDomainReports as $domainReport) {
                $domainKey = $this->getDomainKey($domainReport->pdr_domain);
                
                if ($domainReport->reportAnswers) {
                    foreach ($domainReport->reportAnswers as $answer) {
                        $this->answers[$domainKey][$answer->question_que_id] = $answer->rea_value;
                    }
                }
            }
        }
    }

    private function getDomainKey($domain) {
        switch($domain) {
            case PatientDomainReport::DOMAIN_FIRST:
                return 'first';
            case PatientDomainReport::DOMAIN_SECOND:
                return 'second';
            case PatientDomainReport::DOMAIN_THIRD:
                return 'third';
            default:
                return null;
        }
    }

    public function selectAnswer($domainKey, $questionId, $value) {
        $this->answers[$domainKey][$questionId] = $value;
    }

    public function submitForm() {
        // Validate that all questions are answered
        foreach ($this->questionsByDomain as $domainKey => $domain) {
            foreach ($domain['questions'] as $question) {
                if ($this->answers[$domainKey][$question->que_id] === null) {
                    $this->toast()->error('Por favor, responda todas as perguntas antes de enviar.')->send();
                    return null;
                }
            }
        }

        // Get or update existing PatientReport
        $patientReport = PatientReport::find($this->reportId);
        
        if (!$patientReport) {
            $this->toast()->error('Relatório não encontrado.')->send();
            return null;
        }

        // Update PatientReport status if still pending
        if ($patientReport->par_status === PatientReport::STATUS_PENDING) {
            $patientReport->update(['par_status' => PatientReport::STATUS_COMPLETED]);
        }

        // Create or update PatientDomainReports for each domain for this specific weekday
        foreach ($this->questionsByDomain as $domainKey => $domain) {
            $pdrDomain = $this->getPdrDomain($domainKey);
            
            // Try to find existing PatientDomainReport for this weekday
            $patientDomainReport = PatientDomainReport::where('patient_report_par_id', $this->reportId)
                ->where('pdr_domain', $pdrDomain)
                ->where('pdr_weekday', $this->weekday)
                ->first();

            if (!$patientDomainReport) {
                $patientDomainReport = PatientDomainReport::create([
                    'pdr_domain' => $pdrDomain,
                    'pdr_score' => 0,
                    'pdr_weekday' => $this->weekday,
                    'patient_report_par_id' => $this->reportId,
                ]);
            }

            // Delete existing answers for this domain and weekday
            ReportAnswer::where('patient_domain_report_pdr_id', $patientDomainReport->pdr_id)->delete();

            // Create ReportAnswers for each question
            foreach ($domain['questions'] as $question) {
                ReportAnswer::create([
                    'rea_value' => $this->answers[$domainKey][$question->que_id],
                    'rea_week_day' => $this->weekday,
                    'patient_domain_report_pdr_id' => $patientDomainReport->pdr_id,
                    'question_que_id' => $question->que_id,
                ]);
            }
        }

        $this->toast()->success('Questionário FIQR enviado com sucesso!')->send();
        return $this->redirect(route('patient.fiqr-report'));
    }

    private function getPdrDomain($domainKey) {
        switch($domainKey) {
            case 'first':
                return PatientDomainReport::DOMAIN_FIRST;
            case 'second':
                return PatientDomainReport::DOMAIN_SECOND;
            case 'third':
                return PatientDomainReport::DOMAIN_THIRD;
            default:
                return null;
        }
    }

    public function goBack() {
        return $this->redirect(route('patient.fiqr-report'));
    }

    public function render()
    {
        return view('livewire.patient.patient-fiqr-report-form');
    }
}
