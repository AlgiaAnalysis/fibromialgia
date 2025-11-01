<div class="py-8 pt-4">
    <div class="w-full">
        <div class="mt-4">
            <!-- Main FIQR Report Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="bg-blue-500/10 rounded-xl px-5 py-4 mr-4">
                                <i class="fad fa-clipboard-check text-blue-500 text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Questionários FIQR</h2>
                                <p class="text-sm text-gray-500 mt-1">Avaliação de impacto da fibromialgia</p>
                            </div>
                        </div>
                        @if($lastFiqrReport && $lastFiqrReport->par_status === 'completed' && $lastFiqrReport->par_score !== null)
                            <div class="text-right">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl px-6 py-4 shadow-md">
                                    <p class="text-xs text-blue-100 font-medium mb-1">Último Score</p>
                                    <p class="text-4xl font-bold text-white">{{ number_format($lastFiqrReport->par_score, 2) }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Status Alert -->
                    @if($canCreateNew)
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fad fa-info-circle text-blue-500 text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-1">Pronto para Criar Novo Questionário</h3>
                                    <p class="text-sm text-blue-700">
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
                            class="w-full hover:cursor-pointer bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-blue-600 hover:to-blue-700 flex items-center justify-center disabled:opacity-50">
                            <i class="fad fa-plus-circle mr-3 text-xl" wire:loading.remove wire:target="createNewFiqrReport"></i>
                            <i class="fad fa-spinner fa-spin mr-3 text-xl" wire:loading wire:target="createNewFiqrReport"></i>
                            <span wire:loading.remove wire:target="createNewFiqrReport">Criar Novo Questionário FIQR</span>
                            <span wire:loading wire:target="createNewFiqrReport">Criando...</span>
                        </button>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-5 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fad fa-clock text-yellow-500 text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-yellow-800 mb-1">Aguarde para Criar Novo Questionário</h3>
                                    <p class="text-sm text-yellow-700">
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
                                class="w-full hover:cursor-pointer bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-blue-600 hover:to-blue-700 flex items-center justify-center disabled:opacity-50">
                                <i class="fad fa-eye mr-3 text-xl" wire:loading.remove wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})"></i>
                                <i class="fad fa-spinner fa-spin mr-3 text-xl" wire:loading wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})"></i>
                                <span wire:loading.remove wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})">Visualizar Último Questionário</span>
                                <span wire:loading wire:target="viewFiqrReport({{ $lastFiqrReport->par_id }})">Carregando...</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>

            <!-- History Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-500/10 rounded-xl px-4 py-3 mr-4">
                            <i class="fad fa-clock text-blue-500 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Histórico de Questionários</h3>
                            <p class="text-sm text-gray-500">Últimos questionários respondidos</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        @if($fiqrReports && count($fiqrReports) > 0)
                            <div class="space-y-4">
                                @foreach($fiqrReports as $report)
                                    @php
                                        $isCompleted = $report->par_status === 'completed';
                                    @endphp
                                    <div wire:click="viewFiqrReport({{ $report->par_id }})"
                                         class="hover:cursor-pointer bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-lg p-5 transition-all duration-200 hover:shadow-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <div class="w-14 h-14 bg-blue-500/10 rounded-xl flex items-center justify-center mr-4">
                                                    <i class="fad fa-clipboard-check text-blue-500 text-2xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <h4 class="text-base font-semibold text-gray-800">
                                                            Questionário FIQR
                                                        </h4>
                                                        @if($isCompleted && $report->par_score !== null)
                                                            <div class="flex items-center bg-blue-100 rounded-lg px-3 py-1">
                                                                <span class="text-2xl font-bold text-blue-600 mr-2">
                                                                    {{ number_format($report->par_score, 2) }}
                                                                </span>
                                                                <span class="text-xs text-blue-700 font-medium">Score</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex items-center">
                                                            <i class="fad fa-calendar-day text-gray-400 mr-2 text-sm"></i>
                                                            <span class="text-sm text-gray-600">
                                                                {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m/Y') }}
                                                            </span>
                                                        </div>
                                                        <span class="text-xs {{ $isCompleted ? 'text-green-600' : 'text-orange-600' }} font-medium">
                                                            {{ $isCompleted ? '✓ Completo' : '⏳ Pendente' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <i class="fad fa-chevron-right text-blue-400 text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fad fa-clipboard-check text-gray-400 text-3xl"></i>
                                </div>
                                <p class="text-gray-600 font-medium mb-1">Nenhum questionário encontrado</p>
                                <p class="text-sm text-gray-500">Comece preenchendo seu primeiro questionário acima</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
