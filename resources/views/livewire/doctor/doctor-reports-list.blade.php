<div class="py-8 pt-4 px-13">
    <div class="w-full">
        <!-- Header -->
        <div class="flex items-center mb-8">
            <div class="bg-blue-500/10 rounded-lg px-5 py-4 mr-3">
                <i class="fad fa-clipboard-list text-blue-500 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-blue-500/80">Questionários dos Pacientes</h3>
                <p class="text-sm text-gray-600">Visualize os questionários dos pacientes vinculados</p>
            </div>
        </div>

        <!-- Patients List -->
        <div class="space-y-4">
            @forelse($doctorPatients as $doctorPatient)
                @php
                    $patient = $doctorPatient->patient;
                    $user = $patient->user;
                    $dailyReports = $patient->patientReports->where('par_type', 'domain_daily');
                    $fiqrReports = $patient->patientReports->where('par_type', 'fiqr');
                    $appointments = $patient->appointments;
                    $isExpanded = $expandedPatient === $patient->pat_id;
                @endphp

                <!-- Patient Card -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                    <!-- Patient Header (Clickable) -->
                    <div wire:click="togglePatient({{ $patient->pat_id }})" class="cursor-pointer p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-14 h-14 bg-blue-500/10 rounded-full flex items-center justify-center mr-4">
                                    <i class="fad fa-user-injured text-blue-500 text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $user->usr_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $user->usr_email }}</p>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full font-medium">
                                            {{ $dailyReports->count() }} Diários
                                        </span>
                                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full font-medium ml-2">
                                            {{ $fiqrReports->count() }} FIQR
                                        </span>
                                        <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full font-medium ml-2">
                                            {{ $appointments->count() }} Consultas
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <i wire:loading.remove wire:target="togglePatient({{ $patient->pat_id }})"
                                    class="fad {{ $isExpanded ? 'fa-chevron-up' : 'fa-chevron-down' }} text-gray-400 text-xl"></i>
                                <i wire:loading wire:target="togglePatient({{ $patient->pat_id }})"
                                    class="fad fa-spinner fa-spin text-gray-400 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Expanded Content -->
                    @if($isExpanded)
                        <div class="px-6 pb-6 border-t border-gray-200 animate-fade-in">
                            <div class="pt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Daily Reports Column -->
                                <div class="bg-orange-50 rounded-lg p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-orange-500/20 rounded-lg px-3 py-2 mr-2">
                                            <i class="fad fa-clipboard-prescription text-orange-500"></i>
                                        </div>
                                        <h5 class="font-semibold text-gray-800">Questionários Diários</h5>
                                    </div>
                                    @if($dailyReports->count() > 0)
                                        <div class="space-y-2 max-h-64 overflow-y-auto">
                                            @foreach($dailyReports as $report)
                                                <div wire:click="openReportModal({{ $report->par_id }}, 'daily')"
                                                     class="cursor-pointer bg-white rounded-lg p-3 hover:shadow-md transition-all duration-200 border border-orange-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <span class="text-xs font-bold text-orange-500">
                                                                {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m/Y') }}
                                                            </span>
                                                            @if($report->par_score > 0)
                                                                <span class="text-xs text-gray-600 ml-2">
                                                                    Score: {{ $report->par_score }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <i wire:loading.remove wire:target="openReportModal({{ $report->par_id }}, 'daily')"
                                                            class="fad fa-eye text-orange-500"></i>
                                                        <i wire:loading wire:target="openReportModal({{ $report->par_id }}, 'daily')"
                                                            class="fad fa-spinner fa-spin text-orange-500 text-xl"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 text-center">Nenhum questionário diário</p>
                                    @endif
                                </div>

                                <!-- FIQR Reports Column -->
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-blue-500/20 rounded-lg px-3 py-2 mr-2">
                                            <i class="fad fa-clipboard-check text-blue-500"></i>
                                        </div>
                                        <h5 class="font-semibold text-gray-800">Questionários FIQR</h5>
                                    </div>
                                    @if($fiqrReports->count() > 0)
                                        <div class="space-y-2 max-h-64 overflow-y-auto">
                                            @foreach($fiqrReports as $report)
                                                <div wire:click="openReportModal({{ $report->par_id }}, 'fiqr')"
                                                     class="cursor-pointer bg-white rounded-lg p-3 hover:shadow-md transition-all duration-200 border border-blue-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <span class="text-xs font-bold text-blue-500">
                                                                {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m') }}
                                                                @if($report->par_period_end)
                                                                    - {{ \Carbon\Carbon::parse($report->par_period_end)->format('d/m') }}
                                                                @endif
                                                            </span>
                                                            @if($report->par_score > 0)
                                                                <span class="text-xs text-gray-600 ml-2">
                                                                    Score: {{ $report->par_score }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <i
                                                            wire:loading.remove wire:target="openReportModal({{ $report->par_id }}, 'fiqr')"
                                                            class="fad fa-eye text-blue-500"></i>
                                                        <i wire:loading wire:target="openReportModal({{ $report->par_id }}, 'fiqr')"
                                                            class="fad fa-spinner fa-spin text-blue-500 text-xl"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 text-center">Nenhum FIQR</p>
                                    @endif
                                </div>

                                <!-- Appointments Column -->
                                <div class="bg-purple-50 rounded-lg p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-purple-500/20 rounded-lg px-3 py-2 mr-2">
                                            <i class="fad fa-stethoscope text-purple-500"></i>
                                        </div>
                                        <h5 class="font-semibold text-gray-800">Consultas</h5>
                                    </div>
                                    @if($appointments->count() > 0)
                                        <div class="space-y-2 max-h-64 overflow-y-auto">
                                            @foreach($appointments as $appointment)
                                                <div wire:click="openReportModal({{ $appointment->app_id }}, 'appointment')"
                                                     class="cursor-pointer bg-white rounded-lg p-3 hover:shadow-md transition-all duration-200 border border-purple-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <span class="text-xs font-bold text-purple-500">
                                                                {{ \Carbon\Carbon::parse($appointment->app_date)->format('d/m/Y') }}
                                                            </span>
                                                        </div>
                                                        <i wire:loading.remove wire:target="openReportModal({{ $appointment->app_id }}, 'appointment')"
                                                            class="fad fa-eye text-purple-500"></i>
                                                        <i wire:loading wire:target="openReportModal({{ $appointment->app_id }}, 'appointment')"
                                                            class="fad fa-spinner fa-spin text-purple-500 text-xl"></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 text-center">Nenhuma consulta</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mb-4">
                            <i class="fad fa-users text-blue-500 text-3xl"></i>
                        </div>
                        <p class="text-lg text-blue-700 font-medium mb-2">Nenhum paciente vinculado</p>
                        <p class="text-sm text-blue-600">Vincule pacientes na aba de Pacientes para visualizar seus questionários</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <x-ts-modal
        wire="showModal"
        title="Questionário"
        size="4xl"
        center
    >
        @if($reportData)
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div>
                        @if($reportType === 'daily')
                            <div class="flex items-center">
                                <div class="bg-orange-500/10 rounded-lg px-3 py-2 mr-3">
                                    <i class="fad fa-clipboard-prescription text-orange-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Questionário Diário</h3>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Data: {{ \Carbon\Carbon::parse($reportData->par_period_starts)->format('d/m/Y') }}
                            </p>
                        @elseif($reportType === 'fiqr')
                            <div class="flex items-center">
                                <div class="bg-blue-500/10 rounded-lg px-3 py-2 mr-3">
                                    <i class="fad fa-clipboard-check text-blue-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Questionário FIQR</h3>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Período: {{ \Carbon\Carbon::parse($reportData->par_period_starts)->format('d/m/Y') }}
                                @if($reportData->par_period_end)
                                    até {{ \Carbon\Carbon::parse($reportData->par_period_end)->format('d/m/Y') }}
                                @endif
                            </p>
                        @elseif($reportType === 'appointment')
                            <div class="flex items-center">
                                <div class="bg-purple-500/10 rounded-lg px-3 py-2 mr-3">
                                    <i class="fad fa-stethoscope text-purple-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800">Consulta Médica</h3>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                Data: {{ \Carbon\Carbon::parse($reportData->app_date)->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fad fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Score Cards -->
                @if($reportType === 'daily' && $reportData && $reportData->par_score !== null)
                    <div class="mb-6">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-white/20 rounded-lg px-4 py-3 mr-4">
                                        <i class="fad fa-chart-line text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-semibold text-orange-100 mb-1">Score do Questionário</h4>
                                        <p class="text-xs text-orange-200">Pontuação total</p>
                                    </div>
                                </div>
                                <span class="text-4xl font-bold">{{ number_format($reportData->par_score, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @elseif($reportType === 'fiqr' && $reportData && $reportData->par_status === 'completed' && count($domainScores) > 0)
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Domain 1 Score -->
                            @if(isset($domainScores['first']))
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="bg-white/20 rounded-lg px-3 py-2">
                                            <i class="fad fa-layer-group text-xl"></i>
                                        </div>
                                        <span class="text-3xl font-bold">{{ number_format($domainScores['first']['score'], 2) }}</span>
                                    </div>
                                    <h4 class="text-sm font-semibold text-blue-100 mb-1">{{ $domainScores['first']['name'] }}</h4>
                                    <p class="text-xs text-blue-200">Score do Domínio</p>
                                </div>
                            @endif

                            <!-- Domain 2 Score -->
                            @if(isset($domainScores['second']))
                                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="bg-white/20 rounded-lg px-3 py-2">
                                            <i class="fad fa-layer-group text-xl"></i>
                                        </div>
                                        <span class="text-3xl font-bold">{{ number_format($domainScores['second']['score'], 2) }}</span>
                                    </div>
                                    <h4 class="text-sm font-semibold text-green-100 mb-1">{{ $domainScores['second']['name'] }}</h4>
                                    <p class="text-xs text-green-200">Score do Domínio</p>
                                </div>
                            @endif

                            <!-- Domain 3 Score -->
                            @if(isset($domainScores['third']))
                                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="bg-white/20 rounded-lg px-3 py-2">
                                            <i class="fad fa-layer-group text-xl"></i>
                                        </div>
                                        <span class="text-3xl font-bold">{{ number_format($domainScores['third']['score'], 2) }}</span>
                                    </div>
                                    <h4 class="text-sm font-semibold text-purple-100 mb-1">{{ $domainScores['third']['name'] }}</h4>
                                    <p class="text-xs text-purple-200">Score do Domínio</p>
                                </div>
                            @endif

                            <!-- Total Score -->
                            @if($reportData && $reportData->par_score !== null)
                                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="bg-white/20 rounded-lg px-3 py-2">
                                            <i class="fad fa-chart-line text-xl"></i>
                                        </div>
                                        <span class="text-3xl font-bold">{{ number_format($reportData->par_score, 2) }}</span>
                                    </div>
                                    <h4 class="text-sm font-semibold text-orange-100 mb-1">Score Final</h4>
                                    <p class="text-xs text-orange-200">Total do Questionário</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Answers Content -->
                <div class="max-h-[60vh] overflow-y-auto">
                    @if($reportType === 'daily')
                        @if($reportData->patientDomainReports && $reportData->patientDomainReports->count() > 0)
                            @foreach($reportData->patientDomainReports->first()->reportAnswers as $answer)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-start">
                                        <div class="bg-orange-500/10 rounded-lg px-3 py-2 mr-3">
                                            <i class="fad fa-question-circle text-orange-500"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-800">{{ $answer->question->que_name }}</h4>
                                                <span class="bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-1 rounded-full">
                                                    #{{ $answer->question->que_index }}
                                                </span>
                                            </div>
                                            <div class="mt-3 bg-gray-50 rounded-lg p-3">
                                                <div class="flex items-center">
                                                    <span class="text-2xl font-bold {{ $answer->rea_value >= 7 ? 'text-red-600' : ($answer->rea_value >= 4 ? 'text-orange-600' : 'text-green-600') }}">
                                                        {{ $answer->rea_value }}
                                                    </span>
                                                    <span class="text-sm text-gray-600 ml-2">/ 10</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @elseif($reportType === 'fiqr')
                        @if($reportData && $reportData->patientDomainReports && $reportData->patientDomainReports->count() > 0)
                            @php
                                $domains = ['first' => 'first_domain', 'second' => 'second_domain', 'third' => 'third_domain'];
                                $domainNames = [
                                    'first_domain' => 'Função Física',
                                    'second_domain' => 'Impacto Geral',
                                    'third_domain' => 'Sintomas'
                                ];
                            @endphp
                            @php
                                $hasAnyAnswers = false;
                            @endphp
                            @foreach($domains as $key => $domain)
                                @php
                                    $domainReports = $reportData->patientDomainReports
                                        ->where('pdr_domain', $domain)
                                        ->filter(function($dr) {
                                            return $dr->reportAnswers && $dr->reportAnswers->count() > 0;
                                        })
                                        ->values();
                                    if ($domainReports->count() > 0) {
                                        $hasAnyAnswers = true;
                                    }
                                @endphp
                                @if($domainReports->count() > 0)
                                    <div class="mb-6">
                                        <!-- Domain Header -->
                                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 mb-4">
                                            <h4 class="text-lg font-bold text-white">{{ $domainNames[$domain] }}</h4>
                                        </div>
                                        
                                        <!-- Domain Answers -->
                                        @foreach($domainReports as $domainReport)
                                            @if($domainReport->reportAnswers && $domainReport->reportAnswers->count() > 0)
                                                @foreach($domainReport->reportAnswers as $answer)
                                                    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-3 hover:shadow-md transition-all duration-200">
                                                        <div class="flex items-start">
                                                            <div class="bg-blue-500/10 rounded-lg px-3 py-2 mr-3">
                                                                <i class="fad fa-question-circle text-blue-500"></i>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center justify-between mb-2">
                                                                    <h5 class="font-semibold text-gray-800">{{ $answer->question->que_name }}</h5>
                                                                    <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-2 py-1 rounded-full">
                                                                        #{{ $answer->question->que_index }}
                                                                    </span>
                                                                </div>
                                                                <div class="mt-3 bg-gray-50 rounded-lg p-3">
                                                                    <div class="flex items-center">
                                                                        <span class="text-2xl font-bold {{ $answer->rea_value >= 7 ? 'text-red-600' : ($answer->rea_value >= 4 ? 'text-orange-600' : 'text-green-600') }}">
                                                                            {{ $answer->rea_value }}
                                                                        </span>
                                                                        <span class="text-sm text-gray-600 ml-2">/ 10</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                            
                            @if(!$hasAnyAnswers)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                                    <i class="fad fa-info-circle text-blue-500 text-3xl mb-3"></i>
                                    <p class="text-blue-700 font-medium">Este questionário FIQR ainda não possui respostas preenchidas.</p>
                                </div>
                            @endif
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                                <i class="fad fa-info-circle text-blue-500 text-3xl mb-3"></i>
                                <p class="text-blue-700 font-medium">Não foi possível carregar os dados do questionário FIQR.</p>
                            </div>
                        @endif
                    @elseif($reportType === 'appointment')
                        @if($reportData->appointmentAnswers && $reportData->appointmentAnswers->count() > 0)
                            @foreach($reportData->appointmentAnswers as $answer)
                                <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 hover:shadow-md transition-all duration-200">
                                    <div class="flex items-start">
                                        <div class="bg-purple-500/10 rounded-lg px-3 py-2 mr-3">
                                            <i class="fad fa-question-circle text-purple-500"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="font-semibold text-gray-800">{{ $answer->question->que_name }}</h4>
                                                <span class="bg-purple-100 text-purple-600 text-xs font-semibold px-2 py-1 rounded-full">
                                                    #{{ $answer->question->que_index }}
                                                </span>
                                            </div>
                                            <div class="mt-3 bg-gray-50 rounded-lg p-3">
                                                <p class="text-gray-700 whitespace-pre-wrap">{{ $answer->apa_answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>

                <!-- Medication Prescription Section (Only for daily and fiqr reports) -->
                @if(in_array($reportType, ['daily', 'fiqr']))
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-500/10 rounded-lg px-3 py-2 mr-3">
                                <i class="fad fa-pills text-green-500"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Prescrição de Medicamentos</h3>
                                <p class="text-sm text-gray-500">Prescreva medicamentos para este questionário</p>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <label for="medication" class="block text-sm font-medium text-gray-700 mb-2">
                                Medicamentos Prescritos
                            </label>
                            <textarea
                                id="medication"
                                wire:model="medication"
                                rows="6"
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-500 transition-all duration-200 resize-vertical"
                                placeholder="Digite os medicamentos prescritos para este questionário..."
                            ></textarea>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fad fa-info-circle mr-1"></i>
                                As informações serão salvas automaticamente quando você clicar em "Salvar Medicamentos"
                            </p>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button
                                wire:click="saveMedication"
                                wire:loading.attr="disabled"
                                class="px-6 py-3 hover:cursor-pointer bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-all duration-200 flex items-center disabled:opacity-50 shadow-md">
                                <i class="fad fa-save mr-2" wire:loading.remove wire:target="saveMedication"></i>
                                <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="saveMedication"></i>
                                <span wire:loading.remove wire:target="saveMedication">Salvar Medicamentos</span>
                                <span wire:loading wire:target="saveMedication">Salvando...</span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Modal Footer -->
                <x-slot:footer>
                    <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                        <button wire:click="closeModal" class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold rounded-lg transition-colors">
                            Fechar
                        </button>
                    </div>
                </x-slot:footer>
            </div>
        @endif
    </x-ts-modal>
</div>
