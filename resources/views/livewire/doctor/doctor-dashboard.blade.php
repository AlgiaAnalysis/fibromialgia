<div class="py-8 pt-4">
    @php
        function convertMdToHtml($md) {
            return \Illuminate\Support\Str::markdown($md, [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'max_nesting_level' => 5,
            ]);
        }
    @endphp

    <div class="w-full">
        <!-- Top row with 3 equal-sized cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 mt-6">
            <!-- Quick Access Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <!-- Black header -->
                <div class="bg-blue-300/60 h-30 py-8 pt-5 rounded-b-lg px-6 relative">
                    <div class="flex items-center">
                        <h3 class="text-lg font-semibold text-blue-500/80">Acesso Rápido</h3>
                    </div>
                    
                    <!-- Newsletters button - overlapping -->
                    <div class="absolute left-4 right-4 -bottom-12">
                        <div class="grid grid-cols-2 gap-4">
                            <button wire:click="showAllEditions" class="block w-full">
                                <div class="bg-blue-400 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    <div class="p-4 text-center">
                                        <div class="flex flex-col items-center space-y-2">
                                            <i wire:loading.remove wire:target="showAllEditions"
                                                class="fad fa-clipboard-list text-2xl text-white"></i>
                                            <i wire:loading wire:target="showAllEditions"
                                                class="fad fa-spinner fa-spin text-2xl text-white"></i>
                                            <span class="text-white font-medium">Questionários</span>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <button wire:click="showAllEditions" class="block w-full">
                                <div class="bg-blue-400 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    <div class="p-4 text-center">
                                        <div class="flex flex-col items-center space-y-2">
                                            <i wire:loading.remove wire:target="showAllEditions"
                                                class="fad fa-chart-line text-2xl text-white"></i>
                                            <i wire:loading wire:target="showAllEditions"
                                                class="fad fa-spinner fa-spin text-2xl text-white"></i>
                                            <span class="text-white font-medium">Análises</span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Quick access buttons -->
                <div class="p-4 pt-16 space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Authors button -->
                        <button wire:click="showAllEditions" class="block w-full">
                            <div class="bg-blue-400 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="p-4 text-center">
                                    <div class="flex flex-col items-center space-y-2">
                                        <i wire:loading.remove wire:target="showAllEditions"
                                            class="fad fa-user-injured text-2xl text-white"></i>
                                        <i wire:loading wire:target="showAllEditions"
                                            class="fad fa-spinner fa-spin text-2xl text-white"></i>
                                        <span class="text-white font-medium">Pacientes</span>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Schedule Emails Stats Card Component -->
            <div class="col-span-2">
                <!-- Schedule Emails Stats Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-500/80 rounded-lg px-4 py-3 mr-4">
                                    <i class="fad fa-database text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Estatísticas Gerais</h3>
                                    <p class="text-sm text-gray-500">
                                        Acompanhe as estatísticas gerais do sistema
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <!-- Total -->
                        <div class="flex items-center p-4 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-200">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                                <i class="fad fa-user-injured text-2xl text-gray-800"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Pacientes</h4>
                                <span class="text-xl font-bold text-gray-800">{{ $doctorPatientsCount }}</span>
                            </div>
                        </div>

                        <!-- Sent -->
                        <div class="flex items-center p-4 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-200">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 border border-purple-200 flex items-center justify-center">
                                <i class="fad fa-clipboard-list text-2xl text-purple-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Questionários</h4>
                                <span class="text-xl font-bold text-gray-800">{{ $questionnairesCount }}</span>
                            </div>
                        </div>
                    </div>

                    @if($doctorPatientsCount == 0)
                        <div class="bg-yellow-50 border border-yellow-200 mt-4 rounded-lg p-5">
                            <div class="flex flex-row justify-between items-center">
                                <div class="flex flex-row items-start">
                                    <i class="fad fa-exclamation-triangle text-yellow-500 text-2xl mr-4"></i>
                                    <span class="text-sm text-yellow-500"><strong>Atenção:</strong> Você ainda não possui pacientes cadastrados.</span>
                                </div>

                                <button
                                    wire:click="goToLinkPatient"
                                    class="bg-yellow-500 hover:cursor-pointer text-white px-4 py-2 rounded-lg">
                                    <i
                                        wire:loading.remove
                                        wire:target="goToLinkPatient"
                                        class="fad fa-link text-white text-xl mr-2"></i>
                                    <i
                                        wire:loading
                                        wire:target="goToLinkPatient"
                                        class="fad fa-spinner fa-spin text-white text-xl mr-2"></i>
                                    <span wire:loading.remove wire:target="goToLinkPatient" class="text-white">Vincular Paciente</span>
                                    <span wire:loading wire:target="goToLinkPatient" class="text-white">Processando...</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 mt-4 rounded-lg p-5">
                            <div class="flex flex-row justify-between items-center">
                                <div class="flex flex-row items-start">
                                    <i class="fad fa-check-circle text-green-500 text-2xl mr-4"></i>
                                    <span class="text-sm text-green-500"><strong>Sucesso:</strong> Você possui {{ $doctorPatientsCount }} pacientes cadastrados.</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center my-8">
        <div class="grow h-px bg-gray-300"></div>
            <div class="mx-6">
                <i class="fad fa-heartbeat text-gray-400 text-2xl"></i>
            </div>
        <div class="grow h-px bg-gray-300"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- AI Analyses Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-purple-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-brain text-purple-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Análises de IA</h3>
                        <p class="text-sm text-gray-500">
                            @if($selectedPatientName)
                                Análises de {{ $selectedPatientName }}
                            @else
                                Selecione um paciente para ver as análises
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if($expandedPatientId && !empty($analysesList))
                <div class="space-y-4">
                    @foreach($analysesList as $analysis)
                        <div 
                            wire:click="openAnalysisModal({{ $analysis['id'] }})"
                            class="cursor-pointer bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg border border-purple-200 p-5 hover:shadow-lg transition-all duration-200 hover:border-purple-400">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="bg-purple-500/20 rounded-lg px-3 py-2 mr-3">
                                        <i class="fad fa-brain text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">{{ $analysis['id'] }} - Análise Comparativa</h4>
                                        <p class="text-xs text-gray-600 mt-1">
                                            {{ $analysis['reportCount'] }} questionário(s) • 
                                            {{ $analysis['earliestDate'] }} até {{ $analysis['latestDate'] }}
                                        </p>
                                    </div>
                                </div>
                                <i class="fad fa-chevron-right text-purple-400 text-xl"></i>
                            </div>
                            <div class="mt-3 prose prose-sm max-w-none">
                                <div class="text-gray-700 text-sm markdown-preview" data-markdown="{{ htmlspecialchars($analysis['preview']) }}"></div>
                            </div>
                            <div class="mt-3 pt-3 border-t border-purple-200">
                                <span class="text-xs text-purple-600 font-medium">Clique para ver análise completa →</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fad fa-brain text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-600 font-medium mb-1">Nenhuma análise disponível</p>
                    <p class="text-sm text-gray-500">
                        @if($expandedPatientId)
                            Este paciente ainda não possui análises geradas. Gere análises na tela de Análise Comparativa.
                        @else
                            Selecione um paciente na lista ao lado para visualizar as análises
                        @endif
                    </p>
                </div>
            @endif
        </div>
    
        <!-- Patients List Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-user-injured text-blue-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Lista de Pacientes</h3>
                        <p class="text-sm text-gray-500">
                            Visualize os pacientes vinculados
                        </p>
                    </div>
                </div>
            </div>

            @if($patientsList && count($patientsList) > 0)
                <div class="space-y-4">
                    @foreach($patientsList as $patient)
                        @php
                            $isSelected = $expandedPatientId === $patient['id'];
                        @endphp
                        <div wire:click="selectPatient({{ $patient['id'] }})"
                             class="cursor-pointer bg-white rounded-lg shadow-md border-2 p-5 transition-all duration-200 hover:shadow-lg {{ $isSelected ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-blue-300' }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="w-12 h-12 rounded-lg bg-blue-500/10 border border-blue-200 flex items-center justify-center">
                                        <i class="fad fa-user-injured text-2xl text-blue-500"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-base font-semibold text-gray-800">{{ $patient['name'] }}</h4>
                                        <p class="text-sm text-gray-600">{{ $patient['email'] }}</p>
                                        @if($patient['lastDailyScore'] !== null)
                                            <div class="flex items-center mt-1">
                                                <span class="text-xs text-gray-500 mr-2">Último Score Diário:</span>
                                                <span class="text-lg font-bold text-orange-500">{{ number_format($patient['lastDailyScore'], 0) }}</span>
                                                @if($patient['lastDailyDate'])
                                                    <span class="text-xs text-gray-500 ml-2">
                                                        ({{ \Carbon\Carbon::parse($patient['lastDailyDate'])->format('d/m/Y') }})
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 mt-1">Sem questionários diários</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <i wire:loading.remove wire:target="selectPatient({{ $patient['id'] }})"
                                        class="fad {{ $isSelected ? 'fa-check-circle' : 'fa-circle' }} {{ $isSelected ? 'text-blue-500' : 'text-gray-300' }} text-xl"></i>
                                    <i wire:loading wire:target="selectPatient({{ $patient['id'] }})"
                                        class="fad fa-spinner fa-spin text-gray-400 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fad fa-user-injured text-gray-400 text-3xl"></i>
                    </div>
                    <p class="text-gray-600 font-medium mb-1">Nenhum paciente encontrado</p>
                    <p class="text-sm text-gray-500">Vincule pacientes para visualizar suas informações</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Analysis Modal -->
    <x-ts-modal
        wire="showAnalysisModal"
        title="Análise Comparativa Completa"
        size="4xl"
        center
    >
        @if($selectedAnalysis)
            <div class="p-6">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-purple-500/10 rounded-lg px-4 py-3 mr-3">
                            <i class="fad fa-brain text-purple-500 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Análise Gerada por IA</h3>
                            <p class="text-sm text-gray-600 mt-1">Análise comparativa de questionários</p>
                        </div>
                    </div>
                    <button wire:click="closeAnalysisModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fad fa-times text-xl"></i>
                    </button>
                </div>

                <div class="max-h-[70vh] overflow-y-auto">
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-6 border border-purple-200">
                        <div class="prose prose-purple max-w-none markdown-content" id="analysisContent">
                            {!! convertMdToHtml($selectedAnalysis->rec_ia_analysis) !!}
                        </div>
                    </div>
                </div>
            </div>

            <x-slot:footer>
                <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                    <button wire:click="closeAnalysisModal" class="px-6 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 font-semibold rounded-lg transition-colors">
                        Fechar
                    </button>
                </div>
            </x-slot:footer>
        @endif
    </x-ts-modal>
</div>
</div>