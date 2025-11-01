<div class="py-4 md:py-8 pt-4">
    <div class="w-full">
        <div class="mt-4">
            <!-- Main Daily Report Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
                <div class="p-4 md:p-8">
                    <!-- Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 md:mb-8">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="bg-orange-500/10 rounded-xl px-3 py-3 md:px-5 md:py-4 mr-3 md:mr-4">
                                <i class="fad fa-clipboard-prescription text-orange-500 text-2xl md:text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-gray-800">Questionários Diários</h2>
                                <p class="text-xs md:text-sm text-gray-500 mt-1">Acompanhamento diário de dor e desconforto</p>
                            </div>
                        </div>
                        @if($todayReport && $todayReport->par_score !== null)
                            <div class="w-full md:w-auto md:text-right">
                                <!-- Mobile: Full width with icon -->
                                <div class="md:hidden bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl px-4 py-3 shadow-md w-full">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="bg-white/20 rounded-lg px-3 py-2 mr-3">
                                                <i class="fad fa-chart-line text-white text-xl"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs text-orange-100 font-medium mb-1">Score de Hoje</p>
                                                <p class="text-3xl font-bold text-white">{{ number_format($todayReport->par_score, 0) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Desktop: Original layout without icon -->
                                <div class="hidden md:block bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl px-6 py-4 shadow-md">
                                    <p class="text-xs text-orange-100 font-medium mb-1">Score de Hoje</p>
                                    <p class="text-4xl font-bold text-white">{{ number_format($todayReport->par_score, 0) }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Status Alert -->
                    @if($todayReport)
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 md:p-5 mb-4 md:mb-6">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fad fa-check-circle text-green-500 text-xl md:text-2xl"></i>
                                </div>
                                <div class="ml-3 md:ml-4 flex-1">
                                    <h3 class="text-base md:text-lg font-semibold text-green-800 mb-1">Questionário de Hoje Preenchido</h3>
                                    <p class="text-xs md:text-sm text-green-700">
                                        Você já preencheu o questionário de hoje ({{ \Carbon\Carbon::parse($todayReport->par_period_starts)->format('d/m/Y') }}). Não é possível enviar mais questionários na mesma data.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- View Today's Report Button -->
                        <button
                            wire:click="viewReport({{ $todayReport->par_id }})"
                            wire:loading.attr="disabled"
                            class="w-full hover:cursor-pointer bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-3 md:py-4 px-4 md:px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-green-600 hover:to-green-700 flex items-center justify-center disabled:opacity-50">
                            <i class="fad fa-eye mr-2 md:mr-3 text-lg md:text-xl" wire:loading.remove wire:target="viewReport({{ $todayReport->par_id }})"></i>
                            <i class="fad fa-spinner fa-spin mr-2 md:mr-3 text-lg md:text-xl" wire:loading wire:target="viewReport({{ $todayReport->par_id }})"></i>
                            <span wire:loading.remove wire:target="viewReport({{ $todayReport->par_id }})" class="text-sm md:text-base">Visualizar Questionário de Hoje</span>
                            <span wire:loading wire:target="viewReport({{ $todayReport->par_id }})" class="text-sm md:text-base">Carregando...</span>
                        </button>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4 md:p-5 mb-4 md:mb-6">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fad fa-info-circle text-blue-500 text-xl md:text-2xl"></i>
                                </div>
                                <div class="ml-3 md:ml-4 flex-1">
                                    <h3 class="text-base md:text-lg font-semibold text-blue-800 mb-1">Questionário Pendente</h3>
                                    <p class="text-xs md:text-sm text-blue-700">
                                        Você ainda não preencheu o questionário de hoje. Responda os questionários diários para acompanhar sua saúde e gerar seu score.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- New Questionnaire Button -->
                        <button
                            wire:click="redirectToDailyReportForm"
                            wire:loading.attr="disabled"
                            class="w-full hover:cursor-pointer bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold py-3 md:py-4 px-4 md:px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-orange-600 hover:to-orange-700 flex items-center justify-center disabled:opacity-50">
                            <i class="fad fa-plus-circle mr-2 md:mr-3 text-lg md:text-xl" wire:loading.remove wire:target="redirectToDailyReportForm"></i>
                            <i class="fad fa-spinner fa-spin mr-2 md:mr-3 text-lg md:text-xl" wire:loading wire:target="redirectToDailyReportForm"></i>
                            <span wire:loading.remove wire:target="redirectToDailyReportForm" class="text-sm md:text-base">Preencher Questionário de Hoje</span>
                            <span wire:loading wire:target="redirectToDailyReportForm" class="text-sm md:text-base">Carregando...</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- History Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                <div class="p-4 md:p-8">
                    <!-- Header -->
                    <div class="flex items-center mb-4 md:mb-6">
                        <div class="bg-orange-500/10 rounded-xl px-3 py-2 md:px-4 md:py-3 mr-3 md:mr-4">
                            <i class="fad fa-clock text-orange-500 text-xl md:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-bold text-gray-800">Histórico de Questionários</h3>
                            <p class="text-xs md:text-sm text-gray-500">Últimos questionários respondidos</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-4 md:pt-6">
                        @if($dailyReports && count($dailyReports) > 0)
                            <div class="space-y-3 md:space-y-4">
                                @foreach($dailyReports as $report)
                                    <div wire:click="viewReport({{ $report->par_id }})"
                                         class="hover:cursor-pointer bg-gray-50 hover:bg-orange-50 border border-gray-200 hover:border-orange-300 rounded-lg p-4 md:p-5 transition-all duration-200 hover:shadow-md">
                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div class="flex items-center flex-1 mb-3 md:mb-0">
                                                <div class="w-12 h-12 md:w-14 md:h-14 bg-orange-500/10 rounded-xl flex items-center justify-center mr-3 md:mr-4 shrink-0">
                                                    <i wire:loading.remove wire:target="viewReport({{ $report->par_id }})"
                                                        class="fad fa-clipboard-prescription text-orange-500 text-xl md:text-2xl"></i>
                                                    <i wire:loading wire:target="viewReport({{ $report->par_id }})"
                                                        class="fad fa-spinner fa-spin text-orange-500 text-xl md:text-2xl"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2">
                                                        <h4 class="text-sm md:text-base font-semibold text-gray-800 mb-2 md:mb-0">
                                                            Questionário Diário
                                                        </h4>
                                                        @if($report->par_score !== null)
                                                            <div class="flex items-center bg-orange-100 rounded-lg px-2 py-1 md:px-3 md:py-1 self-start md:self-auto">
                                                                <span class="text-xl md:text-2xl font-bold text-orange-600 mr-2">
                                                                    {{ number_format($report->par_score, 0) }}
                                                                </span>
                                                                <span class="text-xs text-orange-700 font-medium">Score</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fad fa-calendar-day text-gray-400 mr-2 text-xs md:text-sm"></i>
                                                        <span class="text-xs md:text-sm text-gray-600">
                                                            {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="md:ml-4 flex justify-end md:justify-start">
                                                <i class="fad fa-chevron-right text-orange-400 text-lg md:text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 md:p-8 text-center">
                                <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4">
                                    <i class="fad fa-clipboard-prescription text-gray-400 text-2xl md:text-3xl"></i>
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
