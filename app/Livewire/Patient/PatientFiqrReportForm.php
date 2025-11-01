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
use Illuminate\Support\Facades\Auth;

#[Layout(PatientLayout::class)]
class PatientFiqrReportForm extends Component
{
    use Interactions;

    public $questionsByDomain = [];
    public $answers = [];
    public $reportId = null;
    public $existingReport = null;
    public $isViewMode = false;
    public $observation = '';

    public function mount($id = null) {
        if ($id) {
            $this->reportId = $id;
        }
        
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
        if (!$this->reportId) {
            return;
        }
        
        $this->existingReport = PatientReport::where('par_id', $this->reportId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->with('patientDomainReports.reportAnswers.question')
            ->first();

        if ($this->existingReport) {
            // Load observation
            $this->observation = $this->existingReport->par_observation ?? '';

            // Check if already answered (completed)
            if ($this->existingReport->par_status === PatientReport::STATUS_COMPLETED) {
                $this->isViewMode = true;
            }

            // Load answers into the answers array
            if ($this->existingReport->patientDomainReports) {
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
        // Count total unanswered questions
        $totalUnanswered = 0;
        $unansweredPerDomain = [];
        
        foreach ($this->questionsByDomain as $domainKey => $domain) {
            $unansweredCount = 0;
            foreach ($domain['questions'] as $question) {
                if ($this->answers[$domainKey][$question->que_id] === null) {
                    $unansweredCount++;
                    $totalUnanswered++;
                }
            }
            $unansweredPerDomain[$domainKey] = $unansweredCount;
        }
        
        // Validate domain 2 (second) - all questions must be answered
        if ($unansweredPerDomain['second'] > 0) {
            $this->toast()->error('O domínio "Impacto Geral" requer que todas as perguntas sejam respondidas.')->send();
            return null;
        }
        
        // Validate that domains 1 and 3 have at least one answer (to calculate average)
        $firstDomainQuestionCount = count($this->questionsByDomain['first']['questions']);
        $thirdDomainQuestionCount = count($this->questionsByDomain['third']['questions']);
        
        if ($unansweredPerDomain['first'] === $firstDomainQuestionCount) {
            $this->toast()->error('O domínio "Função Física" precisa ter pelo menos uma pergunta respondida.')->send();
            return null;
        }
        
        if ($unansweredPerDomain['third'] === $thirdDomainQuestionCount) {
            $this->toast()->error('O domínio "Sintomas" precisa ter pelo menos uma pergunta respondida.')->send();
            return null;
        }
        
        // Validate maximum of 3 unanswered questions total
        if ($totalUnanswered > 3) {
            $this->toast()->error('Você não pode deixar mais de 3 perguntas sem resposta. Por favor, responda pelo menos algumas perguntas.')->send();
            return null;
        }
        
        // Process answers: fill missing values with domain average for domains 1 and 3
        $processedAnswers = $this->processAnswers();

        // Get or create PatientReport
        if ($this->reportId) {
            $patientReport = PatientReport::find($this->reportId);
            
            if (!$patientReport) {
                $this->toast()->error('Relatório não encontrado.')->send();
                return null;
            }
        } else {
            // Create new PatientReport
            $patientId = Auth::user()->usr_represented_agent;
            $today = date('Y-m-d');
            
            $patientReport = PatientReport::create([
                'par_period_starts' => $today,
                'par_period_end' => $today,
                'par_status' => PatientReport::STATUS_PENDING,
                'par_medication' => '',
                'par_observation' => $this->observation ?? '',
                'par_score' => 0,
                'par_cli_resume' => '',
                'par_type' => PatientReport::TYPE_FIQR,
                'patient_pat_id' => $patientId,
            ]);
            
            $this->reportId = $patientReport->par_id;
        }

        // Update PatientReport status to completed and observation
        $patientReport->update([
            'par_status' => PatientReport::STATUS_COMPLETED,
            'par_observation' => $this->observation ?? ''
        ]);

        $finalScore = 0;
        // Create or update PatientDomainReports for each domain (no weekday)
        foreach ($this->questionsByDomain as $domainKey => $domain) {
            $pdrDomain = $this->getPdrDomain($domainKey);
            
            // Find or create PatientDomainReport for this domain
            $patientDomainReport = PatientDomainReport::where('patient_report_par_id', $this->reportId)
                ->where('pdr_domain', $pdrDomain)
                ->first();

            if (!$patientDomainReport) {
                $patientDomainReport = PatientDomainReport::create([
                    'pdr_domain' => $pdrDomain,
                    'pdr_score' => 0,
                    'patient_report_par_id' => $this->reportId,
                ]);
            }

            // Delete existing answers for this domain
            ReportAnswer::where('patient_domain_report_pdr_id', $patientDomainReport->pdr_id)->delete();

            $scoreSum = 0;
            // Create ReportAnswers for each question using processed answers
            foreach ($domain['questions'] as $question) {
                $answerValue = $processedAnswers[$domainKey][$question->que_id];
                
                ReportAnswer::create([
                    'rea_value' => $answerValue,
                    'rea_week_day' => '', // Empty as weekday is no longer used
                    'patient_domain_report_pdr_id' => $patientDomainReport->pdr_id,
                    'question_que_id' => $question->que_id,
                ]);

                $scoreSum += $answerValue;
            }

            // Calculate domain score: sum / divisor
            // Domain 1 (first): divide by 3
            // Domain 2 (second): divide by 2
            // Domain 3 (third): divide by 2
            $divisor = ($pdrDomain == PatientDomainReport::DOMAIN_FIRST) ? 3 : 2;
            $domainScore = $scoreSum / $divisor;
            
            $patientDomainReport->update(['pdr_score' => $domainScore]);
            $finalScore += $domainScore;
        }

        $patientReport->update(['par_score' => $finalScore]);

        $this->toast()->success('Questionário FIQR enviado com sucesso!')->send();
        return $this->redirect(route('patient.fiqr-report'));
    }

    /**
     * Process answers: fill missing values with domain average for domains 1 and 3
     */
    private function processAnswers() {
        $processedAnswers = $this->answers;
        
        foreach ($this->questionsByDomain as $domainKey => $domain) {
            // Domain 2 (second) must have all answers, skip processing
            if ($domainKey === 'second') {
                continue;
            }
            
            // Calculate average of answered questions for this domain
            $answeredValues = [];
            foreach ($domain['questions'] as $question) {
                $value = $this->answers[$domainKey][$question->que_id];
                if ($value !== null) {
                    $answeredValues[] = $value;
                }
            }
            
            // If there are answered questions, calculate average
            if (!empty($answeredValues)) {
                $domainAverage = array_sum($answeredValues) / count($answeredValues);
                
                // Fill missing answers with average
                foreach ($domain['questions'] as $question) {
                    if ($processedAnswers[$domainKey][$question->que_id] === null) {
                        $processedAnswers[$domainKey][$question->que_id] = $domainAverage;
                    }
                }
            }
        }
        
        return $processedAnswers;
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
        $domainScores = [];
        
        // Get domain scores if report exists and is completed
        if ($this->existingReport
            && $this->existingReport->par_status === PatientReport::STATUS_COMPLETED
            && $this->existingReport->patientDomainReports) {
            foreach ($this->existingReport->patientDomainReports as $domainReport) {
                $domainKey = $this->getDomainKey($domainReport->pdr_domain);
                if ($domainKey) {
                    $domainScores[$domainKey] = [
                        'name' => $this->questionsByDomain[$domainKey]['name'] ?? '',
                        'score' => $domainReport->pdr_score ?? 0
                    ];
                }
            }
        }
        
        return view('livewire.patient.patient-fiqr-report-form', [
            'domainScores' => $domainScores
        ]);
    }
}
