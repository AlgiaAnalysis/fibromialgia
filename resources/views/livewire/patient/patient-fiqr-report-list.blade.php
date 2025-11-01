<div class="py-4 md:py-8 pt-4">
    <div class="w-full">
        <div class="mt-4">
            <!-- Main FIQR Report Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
                <div class="p-4 md:p-8">
                    <!-- Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="bg-blue-500/10 rounded-xl px-3 py-3 md:px-5 md:py-4 mr-3 md:mr-4">
                                <i class="fad fa-clipboard-check text-blue-500 text-2xl md:text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Questionários FIQR</h2>
                                <p class="text-xs md:text-sm text-gray-500 mt-1">Avaliação de impacto da fibromialgia</p>
                            </div>
                        </div>
                        @if($lastFiqrReport && $lastFiqrReport->par_status === 'completed' && $lastFiqrReport->par_score !== null)
                            <div class="w-full md:w-auto md:text-right">
                                <!-- Mobile: Full width with icon -->
                                <div class="md:hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl px-4 py-3 shadow-md w-full">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="bg-white/20 rounded-lg px-3 py-2 mr-3">
                                                <i class="fad fa-chart-line text-white text-xl"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-blue-100 font-medium mb-1">Último Score</p>
                                                <p class="text-3xl font-bold text-white">{{ number_format($lastFiqrReport->par_score, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Desktop: Original layout without icon -->
                                <div class="hidden md:block bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl px-6 py-4 shadow-md">
                                    <p class="text-xs text-blue-100 font-medium mb-1">Último Score</p>
                                    <p class="text-4xl font-bold text-white">{{ number_format($lastFiqrReport->par_score, 2) }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Status Alert -->
                    @if($canCreateNew)
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 md:p-5 mb-4 md:mb-6">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fad fa-info-circle text-blue-500 text-xl md:text-2xl"></i>
                                </div>
                                <div class="ml-3 md:ml-4 flex-1">
                                    <h3 class="text-base md:text-lg font-semibold text-blue-800 mb-1">Pronto para Criar Novo Questionário</h3>
                                    <p class="text-xs md:text-sm text-blue-700">
                                        @if($lastFiqrReport)
                                            Você pode criar um novo questionário FIQR. O último foi preenchido em {{ \Carbon\Carbon::parse($lastFiqrReport->par_period_starts)->format('d/m/Y') }}.
                                        @else
                                            Você ainda não possui questionários FIQR. Crie o primeiro para avaliar o impacto da fibromialgia na sua vida.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Create New FIQR Button -->
                        <button
                            wire:click="createNewFiqrReport"
                            wire:loading.attr="disabled"
                            class="w-full hover:cursor-pointer bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 md:py-4 px-4 md:px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-blue-600 hover:to-blue-700 flex items-center justify-center disabled:opacity-50">
                            <i class="fad fa-plus-circle mr-2 md:mr-3 text-lg md:text-xl" wire:loading.remove wire:target="createNewFiqrReport"></i>
                            <i class="fad fa-spinner fa-spin mr-2 md:mr-3 text-lg md:text-xl" wire:loading wire:target="createNewFiqrReport"></i>
                            <span wire:loading.remove wire:target="createNewFiqrReport" class="text-sm md:text-base">Criar Novo Questionário FIQR</span>
                            <span wire:loading wire:target="createNewFiqrReport" class="text-sm md:text-base">Criando...</span>
                        </button>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4 md:p-5 mb-4 md:mb-6">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fad fa-clock text-yellow-500 text-xl md:text-2xl"></i>
                                </div>
                                <div class="ml-3 md:ml-4 flex-1">
                                    <h3 class="text-base md:text-lg font-semibold text-yellow-800 mb-1">Aguarde para Criar Novo Questionário</h3>
                                    <p class="text-xs md:text-sm text-yellow-700">
                                        Você só pode preencher um novo questionário FIQR após 7 dias do último preenchimento.
                                        @if($daysRemaining > 0)
                                            Faltam <strong>{{ $daysRemaining }}</strong> dia(s).
                                        @endif
                                        @if($lastFiqrReport)
                                            O último questionário foi preenchido em {{ \Carbon\Carbon::parse($lastFiqrReport->par_period_starts)->format('d/m/Y') }}.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- View Last Report Button -->
                        @if($lastFiqrReport)
                            <button
                                wire:click="viewFiqrReport({{ $lastFiqrReport->par_id }})"
                                wire:loading.attr="disabled"
                                class="w-full hover:cursor-pointer bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-3 md:py-4 px-4 md:px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-blue-600 hover:to-blue-700 flex items-center justify-center disabled:opacity-50">
                                <i class="fad fa-eye mr-2 md:mr-3 text-lg md:text-xl" wire:loading.remove wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})"></i>
                                <i class="fad fa-spinner fa-spin mr-2 md:mr-3 text-lg md:text-xl" wire:loading wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})"></i>
                                <span wire:loading.remove wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})" class="text-sm md:text-base">Visualizar Último Questionário</span>
                                <span wire:loading wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})" class="text-sm md:text-base">Carregando...</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>

            <!-- History Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                <div class="p-4 md:p-8">
                    <!-- Header -->
                    <div class="flex items-center mb-4 md:mb-6">
                        <div class="bg-blue-500/10 rounded-xl px-3 py-2 md:px-4 md:py-3 mr-3 md:mr-4">
                            <i class="fad fa-clock text-blue-500 text-xl md:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-bold text-gray-800">Histórico de Questionários</h3>
                            <p class="text-xs md:text-sm text-gray-500">Últimos questionários respondidos</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 md:pt-6">
                        @if($fiqrReports && count($fiqrReports) > 0)
                            <div class="space-y-3 md:space-y-4">
                                @foreach($fiqrReports as $report)
                                    @php
                                        $isCompleted = $report->par_status === 'completed';
                                    @endphp
                                    <div wire:click="viewFiqrReport({{ $report->par_id }})"
                                         class="hover:cursor-pointer bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg p-4 md:p-5 transition-all duration-200 hover:shadow-md">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div class="flex items-center flex-1 mb-3 md:mb-0">
                                                <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-500/10 rounded-xl flex items-center justify-center mr-3 md:mr-4 shrink-0">
                                                    <i
                                                        wire:loading.remove wire:target="viewFiqrReport({{ $report->par_id }})"
                                                        class="fad fa-clipboard-check text-blue-500 text-xl md:text-2xl"></i>
                                                    <i wire:loading wire:target="viewFiqrReport({{ $report->par_id }})"
                                                        class="fad fa-spinner fa-spin text-blue-500 text-xl md:text-2xl"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2">
                                                        <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2 md:mb-0">
                                                            Questionário FIQR
                                                        </h4>
                                                        @if($isCompleted && $report->par_score !== null)
                                                            <div class="flex items-center bg-blue-100 rounded-lg px-2 py-1 md:px-3 md:py-1 self-start md:self-auto">
                                                                <span class="text-xl md:text-2xl font-bold text-blue-600 mr-2">
                                                                    {{ number_format($report->par_score, 2) }}
                                                                </span>
                                                                <span class="text-xs text-blue-700 font-medium">Score</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center">
                                                            <i class="fad fa-calendar-day text-gray-400 mr-2 text-xs md:text-sm"></i>
                                                            <span class="text-xs md:text-sm text-gray-600">
                                                                {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m/Y') }}
                                                            </span>
                                                        </div>
                                                        <span class="text-xs {{ $isCompleted ? 'text-green-600' : 'text-orange-600' }} font-medium">
                                                            {{ $isCompleted ? '✓ Completo' : '⏳ Pendente' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:ml-4 flex justify-end md:justify-start">
                                                <i class="fad fa-chevron-right text-blue-400 text-lg md:text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 md:p-8 text-center">
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                    <i class="fad fa-clipboard-check text-gray-400 text-2xl md:text-3xl"></i>
                                </div>
                                <p class="text-sm md:text-base text-gray-600 font-medium mb-1">Nenhum questionário encontrado</p>
                                <p class="text-xs md:text-sm text-gray-500">Comece preenchendo seu primeiro questionário acima</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
