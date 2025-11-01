<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\DoctorLayout;
use App\Models\DoctorPatients;
use App\Models\PatientReport;
use App\Models\ReportComparisons;
use App\Models\ReportsInComparisons;
use App\Models\AppointmentsInComparisons;
use App\Models\Appointment;
use App\Models\AppointmentAnswer;
use App\Service\GeminiService;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

#[Layout(DoctorLayout::class)]
class DoctorReportAnalysis extends Component
{
    use Interactions;

    public $selectedPatientId = null;
    public $selectedReports = []; // Array de IDs de PatientReport selecionados
    public $selectedAppointments = []; // Array de IDs de Appointment selecionados
    public $availableReports = []; // Lista de reports disponíveis do paciente
    public $availableAppointments = []; // Lista de appointments disponíveis do paciente
    public $analysisResult = null; // Resultado da análise da IA
    public $isGenerating = false;

    public function mount()
    {
        // Component is ready
    }

    public function selectPatient($patientId)
    {
        $this->selectedPatientId = $patientId;
        $this->selectedReports = [];
        $this->selectedAppointments = [];
        $this->analysisResult = null;
        $this->loadPatientReports();
        $this->loadPatientAppointments();
    }

    public function toggleReport($reportId)
    {
        if (in_array($reportId, $this->selectedReports)) {
            // Remove if already selected
            $this->selectedReports = array_values(array_filter($this->selectedReports, fn($id) => $id !== $reportId));
        } else {
            // Add if not selected and limit is not reached
            if (count($this->selectedReports) < 3) {
                $this->selectedReports[] = $reportId;
            } else {
                $this->toast()->error('Você só pode selecionar até 3 questionários para análise.')->send();
            }
        }
    }

    public function toggleAppointment($appointmentId)
    {
        if (in_array($appointmentId, $this->selectedAppointments)) {
            // Remove if already selected
            $this->selectedAppointments = array_values(array_filter($this->selectedAppointments, fn($id) => $id !== $appointmentId));
        } else {
            // Add if not selected and limit is not reached
            if (count($this->selectedAppointments) < 2) {
                $this->selectedAppointments[] = $appointmentId;
            } else {
                $this->toast()->error('Você só pode selecionar até 2 consultas para análise.')->send();
            }
        }
    }

    public function generateAnalysis()
    {
        $totalSelected = count($this->selectedReports) + count($this->selectedAppointments);
        
        if ($totalSelected < 2) {
            $this->toast()->error('Selecione pelo menos 2 itens (questionários e/ou consultas) para gerar a análise comparativa.')->send();
            return;
        }

        $this->isGenerating = true;

        try {
            // Load selected reports with all data
            $reports = [];
            if (!empty($this->selectedReports)) {
                $reports = PatientReport::whereIn('par_id', $this->selectedReports)
                    ->with([
                        'patientDomainReports.reportAnswers.question',
                        'patient'
                    ])
                    ->orderBy('par_period_starts', 'asc')
                    ->get();
            }

            // Load selected appointments with all data
            $appointments = [];
            if (!empty($this->selectedAppointments)) {
                $appointments = Appointment::whereIn('app_id', $this->selectedAppointments)
                    ->with([
                        'appointmentAnswers.question',
                        'patient'
                    ])
                    ->orderBy('app_date', 'asc')
                    ->get();
            }

            // Prepare data for Gemini
            $reportData = [];
            foreach ($reports as $report) {
                $answers = [];
                
                // Get all answers from all domains
                if ($report->patientDomainReports) {
                    foreach ($report->patientDomainReports as $domainReport) {
                        if ($domainReport->reportAnswers) {
                            foreach ($domainReport->reportAnswers as $answer) {
                                $questionName = $answer->question->que_name ?? 'Sem nome';
                                $answers[] = [
                                    'question' => $questionName,
                                    'value' => $answer->rea_value,
                                    'domain' => $domainReport->pdr_domain ?? 'N/A',
                                    'domain_score' => $domainReport->pdr_score ?? 0,
                                ];
                            }
                        }
                    }
                }

                $reportData[] = [
                    'report_id' => $report->par_id,
                    'type' => $report->par_type,
                    'status' => $report->par_status,
                    'period_start' => $report->par_period_starts,
                    'period_end' => $report->par_period_end,
                    'score' => $report->par_score,
                    'medication' => $report->par_medication,
                    'clinical_resume' => $report->par_cli_resume,
                    'answers' => $answers,
                ];
            }

            // Prepare appointment data for Gemini
            $appointmentData = [];
            foreach ($appointments as $appointment) {
                $answers = [];
                
                // Get all answers from appointment
                if ($appointment->appointmentAnswers) {
                    foreach ($appointment->appointmentAnswers as $answer) {
                        $questionName = $answer->question->que_name ?? 'Sem nome';
                        $answers[] = [
                            'question' => $questionName,
                            'answer' => $answer->apa_answer ?? 'Sem resposta',
                        ];
                    }
                }

                $appointmentData[] = [
                    'appointment_id' => $appointment->app_id,
                    'date' => $appointment->app_date,
                    'diagnosis' => $appointment->app_diagnosis ?? 'N/A',
                    'answers' => $answers,
                ];
            }

            // Build prompt for Gemini
            $prompt = $this->buildPrompt($reportData, $appointmentData);

            // Call Gemini Service
            $geminiService = new GeminiService();
            $analysis = $geminiService->generateText($prompt);

            // Create ReportComparison
            $comparison = ReportComparisons::create([
                'rec_ia_analysis' => $analysis,
            ]);

            // Create ReportsInComparisons for each selected report
            foreach ($this->selectedReports as $reportId) {
                ReportsInComparisons::create([
                    'patient_report_par_id' => $reportId,
                    'report_comparison_rec_id' => $comparison->rec_id,
                ]);
            }

            // Create AppointmentsInComparisons for each selected appointment
            foreach ($this->selectedAppointments as $appointmentId) {
                AppointmentsInComparisons::create([
                    'appointment_app_id' => $appointmentId,
                    'report_comparison_rec_id' => $comparison->rec_id,
                ]);
            }

            $this->analysisResult = $analysis;
            $this->toast()->success('Análise gerada com sucesso!')->send();

        } catch (\Exception $e) {
            $this->toast()->error('Erro ao gerar análise: ' . $e->getMessage())->send();
        } finally {
            $this->isGenerating = false;
        }
    }

    private function buildPrompt(array $reportData, array $appointmentData = []): string
    {
        $prompt = "Analise comparativa de questionários médicos e consultas de fibromialgia:\n\n";
        
        // Add reports data
        if (!empty($reportData)) {
            foreach ($reportData as $index => $report) {
                $reportNum = $index + 1;
                $prompt .= "=== QUESTIONÁRIO {$reportNum} ===\n";
                $prompt .= "Tipo: {$report['type']}\n";
                $prompt .= "Data de início: {$report['period_start']}\n";
                $prompt .= "Data de término: " . ($report['period_end'] ?? 'N/A') . "\n";
                $prompt .= "Status: {$report['status']}\n";
                $prompt .= "Score total: " . ($report['score'] ?? 0) . "\n";
                $prompt .= "Medicação: " . ($report['medication'] ?? 'N/A') . "\n";
                $prompt .= "Resumo clínico: " . ($report['clinical_resume'] ?? 'N/A') . "\n";
                $prompt .= "\nRespostas:\n";
                
                foreach ($report['answers'] as $answer) {
                    $prompt .= "- {$answer['question']}: {$answer['value']} (Domínio: {$answer['domain']}, Score do domínio: {$answer['domain_score']})\n";
                }
                
                $prompt .= "\n\n";
            }
        }

        // Add appointments data
        if (!empty($appointmentData)) {
            foreach ($appointmentData as $index => $appointment) {
                $appointmentNum = $index + 1;
                $prompt .= "=== CONSULTA MÉDICA {$appointmentNum} ===\n";
                $prompt .= "Data: {$appointment['date']}\n";
                $prompt .= "Diagnóstico: {$appointment['diagnosis']}\n";
                $prompt .= "\nRespostas/Observações:\n";
                
                foreach ($appointment['answers'] as $answer) {
                    $prompt .= "- {$answer['question']}: {$answer['answer']}\n";
                }
                
                $prompt .= "\n\n";
            }
        }

        $prompt .= "Analise os dados acima e identifique:\n";
        $prompt .= "1. Tendências e mudanças nos scores dos questionários ao longo do tempo\n";
        $prompt .= "2. Variações significativas nas respostas aos questionários\n";
        $prompt .= "3. Correlações entre os resultados dos questionários e as informações das consultas médicas\n";
        $prompt .= "4. Padrões que possam indicar melhora ou piora da condição\n";
        $prompt .= "5. Relação entre medicação (quando informada), scores e respostas\n";
        $prompt .= "6. Discrepâncias ou concordâncias entre os achados dos questionários e os diagnósticos/observações das consultas\n";
        $prompt .= "7. Recomendações baseadas na comparação completa\n";
        $prompt .= "\nForneça uma análise detalhada e profissional em português brasileiro, formatada em Markdown.";

        return $prompt;
    }

    private function loadPatientReports()
    {
        if (!$this->selectedPatientId) {
            $this->availableReports = [];
            return;
        }

        $this->availableReports = PatientReport::where('patient_pat_id', $this->selectedPatientId)
            ->where('par_status', PatientReport::STATUS_COMPLETED)
            ->with('patientDomainReports')
            ->orderBy('par_period_starts', 'desc')
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->par_id,
                    'type' => $report->par_type,
                    'period_start' => $report->par_period_starts,
                    'period_end' => $report->par_period_end,
                    'score' => $report->par_score,
                    'status' => $report->par_status,
                ];
            })
            ->toArray();
    }

    private function loadPatientAppointments()
    {
        if (!$this->selectedPatientId) {
            $this->availableAppointments = [];
            return;
        }

        $this->availableAppointments = Appointment::where('patient_pat_id', $this->selectedPatientId)
            ->with('appointmentAnswers')
            ->orderBy('app_date', 'desc')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->app_id,
                    'date' => $appointment->app_date,
                    'diagnosis' => $appointment->app_diagnosis ?? 'N/A',
                    'answers_count' => $appointment->appointmentAnswers ? $appointment->appointmentAnswers->count() : 0,
                ];
            })
            ->toArray();
    }

    public function render()
    {
        $doctorId = Auth::user()->usr_represented_agent;
        
        $doctorPatients = DoctorPatients::where('doctor_doc_id', $doctorId)
            ->where('dop_status', DoctorPatients::STATUS_LINKED)
            ->with(['patient.user'])
            ->get();

        $patientsList = $doctorPatients->map(function ($doctorPatient) {
            $patient = $doctorPatient->patient;
            return [
                'id' => $patient->pat_id,
                'name' => $patient->user->usr_name ?? 'Sem nome',
                'email' => $patient->user->usr_email ?? '',
            ];
        })->toArray();

        return view('livewire.doctor.doctor-report-analysis', [
            'patientsList' => $patientsList,
        ]);
    }
}
