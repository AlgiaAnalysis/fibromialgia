<div class="py-8 pt-4">
    <div class="w-full">
        <div class="mt-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-center">
                    <i class="fad fa-info-circle text-blue-500 mr-2"></i>
                    <p class="text-sm text-blue-700">
                        <strong>Informação:</strong> Faça um teste da funcionalidade de áudio no player. Este áudio foi gerado dentro do WebNews para a primeira edição de newsletter publicada!
                    </p>
                </div>
            </div>

            <!-- First Row: Large Line Chart + Circular Progress -->
            <div class="grid grid-cols-3 gap-6 mb-6 mt-8">
                <!-- Large Line Chart Card (2 columns) -->
                <div class="col-span-2 bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="flex flex-col p-6 h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-orange-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-clipboard-prescription text-orange-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Questionários Diários</h3>
                                    <p class="text-sm text-gray-500">Acompanhamento diário de dor e desconforto</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center my-6">
                            <div class="grow h-px bg-gray-300/60"></div>
                        </div>

                        @if($todayReport)
                            <!-- Already Filled Today Warning -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                                <div class="flex items-start">
                                    <div class="shrink-0">
                                        <i class="fad fa-exclamation-triangle text-yellow-500 mr-2 text-lg"></i>
                                    </div>
                                    <div class="ml-2">
                                        <p class="text-sm text-yellow-800">
                                            <strong>Atenção:</strong> Você já preencheu o questionário de hoje. Não é possível enviar mais questionários na mesma data.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- View Today's Report Button -->
                            <div
                                wire:click="viewReport({{ $todayReport->par_id }})"
                                class="border border-dashed border-green-400/60 hover:cursor-pointer hover:bg-green-400/10 transition-all duration-300 rounded-lg p-3 mt-2 flex-1">
                                <div class="flex flex-col items-center justify-center h-full min-h-[120px]">
                                    <div class="h-16 w-16 bg-green-500/10 rounded-xl flex items-center justify-center">
                                        <i
                                            wire:loading.remove wire:target="viewReport({{ $todayReport->par_id }})"
                                            class="fad fa-eye text-green-500 text-3xl"></i>
                                        <i
                                            wire:loading wire:target="viewReport({{ $todayReport->par_id }})"
                                            class="fad fa-spinner fa-spin text-green-500 text-3xl"></i>
                                    </div>
                                    <p class="text-green-500 text-md font-medium mt-3">Visualizar Questionário de Hoje</p>
                                </div>
                            </div>
                        @else
                            <!-- Info Message -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="fad fa-info-circle text-blue-500 mr-2"></i>
                                    <p class="text-sm text-blue-700">
                                        <strong>Informação:</strong> Responda os questionários diários para acompanhar sua saúde e gerar seu score.
                                    </p>
                                </div>
                            </div>

                            <!-- New Questionnaire Button -->
                            <div
                                wire:click="redirectToDailyReportForm"
                                class="border border-dashed border-orange-400/60 hover:cursor-pointer hover:bg-orange-400/10 transition-all duration-300 rounded-lg p-3 mt-6 flex-1">
                                <div class="flex flex-col items-center justify-center h-full min-h-[120px]">
                                    <div class="h-16 w-16 bg-orange-500/10 rounded-xl flex items-center justify-center">
                                        <i
                                            wire:loading.remove wire:target="redirectToDailyReportForm"
                                            class="fad fa-plus-circle text-orange-500 text-3xl"></i>
                                        <i
                                            wire:loading wire:target="redirectToDailyReportForm"
                                            class="fad fa-spinner fa-spin text-orange-500 text-3xl"></i>
                                    </div>
                                    <p class="text-orange-500 text-md font-medium mt-3">Clique para preencher o questionário</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Circular Progress Card (1 column) -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-orange-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-clock text-orange-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Últimas Respostas</h3>
                                    <p class="text-sm text-gray-500">Respostas dos últimos 10 questionários</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center my-6">
                            <div class="grow h-px bg-gray-300/60"></div>
                        </div>

                        @if($dailyReports && count($dailyReports) > 0)
                            @foreach($dailyReports as $report)
                                <div wire:click="viewReport({{ $report->par_id }})" class="flex flex-row justify-between mt-6 hover:cursor-pointer bg-white rounded-lg shadow-md w-full p-6 border border-gray-200 transition-all duration-200 hover:shadow-lg">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg bg-orange-500/10 border border-orange-200 flex items-center justify-center">
                                            <i class="fad fa-clipboard-prescription text-2xl text-orange-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-500">Questionário Diário</h4>
                                            <span class="text-md font-bold text-orange-500">{{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fad fa-info-circle text-gray-400 mr-2"></i>
                                    <p class="text-sm text-gray-600">
                                        Nenhum questionário encontrado ainda.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
