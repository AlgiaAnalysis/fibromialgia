<div class="py-8 pt-4 px-13">
    <div class="w-full">
        <!-- Header -->
        <div class="flex items-center mb-8">
            <div class="bg-purple-500/10 rounded-lg px-5 py-4 mr-3">
                <i class="fad fa-chart-line text-purple-500 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-purple-500/80">Análise Comparativa de Questionários</h3>
                <p class="text-sm text-gray-600">Compare questionários de pacientes usando análise de IA</p>
            </div>
        </div>

        <!-- Step 1: Patient Selection -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
            <div class="flex items-center mb-4">
                <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                    <i class="fad fa-user-injured text-blue-500 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">1. Selecione um Paciente</h3>
                    <p class="text-sm text-gray-500">Escolha o paciente para análise</p>
                </div>
            </div>

            @if(count($patientsList) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($patientsList as $patient)
                        @php
                            $isSelected = $selectedPatientId === $patient['id'];
                        @endphp
                        <button
                            wire:click="selectPatient({{ $patient['id'] }})"
                            class="p-4 hover:cursor-pointer rounded-lg border-2 transition-all duration-200 hover:shadow-md {{ $isSelected ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-lg {{ $isSelected ? 'bg-purple-500/20' : 'bg-gray-100' }} flex items-center justify-center mr-3">
                                    <i class="fad fa-user-injured text-2xl {{ $isSelected ? 'text-purple-500' : 'text-gray-400' }}"></i>
                                </div>
                                <div class="text-left flex-1">
                                    <h4 class="font-semibold text-gray-800">{{ $patient['name'] }}</h4>
                                    <p class="text-xs text-gray-500">{{ $patient['email'] }}</p>
                                </div>
                                @if($isSelected)
                                    <i class="fad fa-check-circle text-purple-500 text-xl"></i>
                                @endif
                            </div>
                        </button>
                    @endforeach
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fad fa-user-injured text-blue-500 text-3xl"></i>
                    </div>
                    <p class="text-gray-600 font-medium mb-1">Nenhum paciente vinculado</p>
                    <p class="text-sm text-gray-500">Vincule pacientes para realizar análises</p>
                </div>
            @endif
        </div>

        <!-- Step 2: Report and Appointment Selection -->
        @if($selectedPatientId)
            <!-- Reports Selection -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="bg-green-500/10 rounded-lg px-4 py-3 mr-3">
                            <i class="fad fa-clipboard-list text-green-500 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">2. Selecione os Questionários</h3>
                            <p class="text-sm text-gray-500">
                                Selecione até 3 questionários para comparação
                                @if(count($selectedReports) > 0)
                                    <span class="text-green-600 font-medium">({{ count($selectedReports) }} selecionado(s))</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if(count($availableReports) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($availableReports as $report)
                            @php
                                $isSelected = in_array($report['id'], $selectedReports);
                                $typeLabel = $report['type'] === 'domain_daily' ? 'Diário' : ($report['type'] === 'fiqr' ? 'FIQR' : 'Desconhecido');
                                
                                // Determine icon and color classes based on type
                                if ($report['type'] === 'domain_daily') {
                                    $iconClass = 'fa-clipboard-prescription';
                                    $bgColorClass = $isSelected ? 'bg-purple-500/20' : 'bg-orange-100';
                                    $textColorClass = 'text-orange-500';
                                    $badgeBgClass = 'bg-orange-100';
                                    $badgeTextClass = 'text-orange-600';
                                } else {
                                    $iconClass = 'fa-clipboard-check';
                                    $bgColorClass = $isSelected ? 'bg-purple-500/20' : 'bg-blue-100';
                                    $textColorClass = 'text-blue-500';
                                    $badgeBgClass = 'bg-blue-100';
                                    $badgeTextClass = 'text-blue-600';
                                }
                            @endphp
                            <button
                                wire:click="toggleReport({{ $report['id'] }})"
                                class="p-4 hover:cursor-pointer rounded-lg border-2 transition-all duration-200 hover:shadow-md text-left {{ $isSelected ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg {{ $bgColorClass }} flex items-center justify-center mr-2">
                                            <i class="fad {{ $iconClass }} {{ $textColorClass }} text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Questionário {{ $typeLabel }}</h4>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($report['period_start'])->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($isSelected)
                                        <i class="fad fa-check-circle text-purple-500 text-xl"></i>
                                    @else
                                        <i class="fad fa-circle text-gray-300 text-xl"></i>
                                    @endif
                                </div>
                                @if($report['score'] !== null)
                                    <div class="mt-2">
                                        <span class="text-xs {{ $badgeBgClass }} {{ $badgeTextClass }} px-2 py-1 rounded-full font-medium">
                                            Score: {{ number_format($report['score'], $report['type'] === 'fiqr' ? 2 : 0) }}
                                        </span>
                                    </div>
                                @endif
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <i class="fad fa-info-circle text-yellow-500 text-3xl mb-3"></i>
                        <p class="text-gray-600 font-medium mb-1">Nenhum questionário disponível</p>
                        <p class="text-sm text-gray-500">Este paciente ainda não possui questionários completos</p>
                    </div>
                @endif
            </div>

            <!-- Appointments Selection -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="bg-purple-500/10 rounded-lg px-4 py-3 mr-3">
                            <i class="fad fa-stethoscope text-purple-500 text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">3. Selecione as Consultas (Opcional)</h3>
                            <p class="text-sm text-gray-500">
                                Selecione até 2 consultas médicas para comparação
                                @if(count($selectedAppointments) > 0)
                                    <span class="text-purple-600 font-medium">({{ count($selectedAppointments) }} selecionada(s))</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @php
                        $totalSelected = count($selectedReports) + count($selectedAppointments);
                    @endphp
                    @if($totalSelected >= 2)
                        <button
                            wire:click="generateAnalysis"
                            wire:loading.attr="disabled"
                            class="px-6 py-3 hover:cursor-pointer bg-purple-500 text-white font-semibold rounded-lg hover:bg-purple-600 transition-all duration-200 flex items-center disabled:opacity-50 shadow-md">
                            <i class="fad fa-magic mr-2" wire:loading.remove wire:target="generateAnalysis"></i>
                            <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="generateAnalysis"></i>
                            <span wire:loading.remove wire:target="generateAnalysis">Gerar Análise</span>
                            <span wire:loading wire:target="generateAnalysis">Gerando...</span>
                        </button>
                    @endif
                </div>

                @if(count($availableAppointments) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($availableAppointments as $appointment)
                            @php
                                $isSelected = in_array($appointment['id'], $selectedAppointments);
                            @endphp
                            <button
                                wire:click="toggleAppointment({{ $appointment['id'] }})"
                                class="p-4 hover:cursor-pointer rounded-lg border-2 transition-all duration-200 hover:shadow-md text-left {{ $isSelected ? 'border-purple-500 bg-purple-50' : 'border-gray-200 hover:border-purple-300' }}">
                                <div class="flex items-start justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg {{ $isSelected ? 'bg-purple-500/20' : 'bg-purple-100' }} flex items-center justify-center mr-2">
                                            <i class="fad fa-stethoscope {{ $isSelected ? 'text-purple-500' : 'text-purple-400' }} text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Consulta Médica</h4>
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($appointment['date'])->format('d/m/Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($isSelected)
                                        <i class="fad fa-check-circle text-purple-500 text-xl"></i>
                                    @else
                                        <i class="fad fa-circle text-gray-300 text-xl"></i>
                                    @endif
                                </div>
                                <div class="mt-2 space-y-1">
                                    @if($appointment['diagnosis'] && $appointment['diagnosis'] !== 'N/A')
                                        <div class="text-xs text-purple-600 font-medium">
                                            <i class="fad fa-diagnoses mr-1"></i>Diagnóstico: {{ \Illuminate\Support\Str::limit($appointment['diagnosis'], 30) }}
                                        </div>
                                    @endif
                                    @if($appointment['answers_count'] > 0)
                                        <div class="text-xs text-gray-500">
                                            <i class="fad fa-clipboard-list mr-1"></i>{{ $appointment['answers_count'] }} resposta(s)
                                        </div>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 text-center">
                        <i class="fad fa-info-circle text-purple-500 text-3xl mb-3"></i>
                        <p class="text-gray-600 font-medium mb-1">Nenhuma consulta disponível</p>
                        <p class="text-sm text-gray-500">Este paciente ainda não possui consultas registradas</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Step 3: Analysis Result -->
        @if($analysisResult)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-brain text-purple-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Análise Comparativa</h3>
                        <p class="text-sm text-gray-500">Resultado da análise gerada pela IA</p>
                    </div>
                </div>

                @php
                    function convertMdToHtml($md) {
                        return \Illuminate\Support\Str::markdown($md, [
                            'html_input' => 'strip',
                            'allow_unsafe_links' => false,
                            'max_nesting_level' => 5,
                        ]);
                    }
                @endphp

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                    <div class="prose max-w-none">
                        <div class="text-gray-700 whitespace-pre-wrap leading-relaxed">{!! convertMdToHtml($analysisResult) !!}</div>
                    </div>  
                </div>
            </div>
        @endif

        @if($isGenerating)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <i class="fad fa-spinner fa-spin text-purple-500 text-4xl mb-4"></i>
                        <p class="text-gray-600 font-medium">Gerando análise com IA...</p>
                        <p class="text-sm text-gray-500 mt-2">Isso pode levar alguns segundos</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
