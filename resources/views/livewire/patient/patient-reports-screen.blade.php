<div class="py-8 pt-4">
    <div class="w-full">
        <!-- Header -->
        <div class="flex items-center mb-8">
            <div class="bg-blue-500/10 rounded-lg px-5 py-4 mr-3">
                <i class="fad fa-clipboard-list text-blue-500 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-blue-500/80">Relatórios e Questionários</h3>
                <p class="text-sm text-gray-600">Visualize e gerencie todos os seus relatórios</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Daily Reports Section -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-orange-500/10 rounded-lg px-4 py-3 mr-3">
                                <i class="fad fa-clipboard-prescription text-orange-500 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Questionários Diários</h3>
                                <p class="text-sm text-gray-500">Acompanhamento diário</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center my-6">
                        <div class="grow h-px bg-gray-300/60"></div>
                    </div>

                    @if($todayDailyReport)
                        <!-- Already Filled Today Warning -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fad fa-exclamation-triangle text-yellow-500 mr-2 text-lg"></i>
                                </div>
                                <div class="ml-2">
                                    <p class="text-xs text-yellow-800">
                                        <strong>Atenção:</strong> Questionário de hoje já preenchido.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- View Today's Report Button -->
                        <div
                            wire:click="viewDailyReport({{ $todayDailyReport->par_id }})"
                            class="border border-dashed border-green-400/60 hover:cursor-pointer hover:bg-green-400/10 transition-all duration-300 rounded-lg p-3 mb-4">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-12 w-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                                    <i
                                        wire:loading.remove wire:target="viewDailyReport({{ $todayDailyReport->par_id }})"
                                        class="fad fa-eye text-green-500 text-xl"></i>
                                    <i
                                        wire:loading wire:target="viewDailyReport({{ $todayDailyReport->par_id }})"
                                        class="fad fa-spinner fa-spin text-green-500 text-xl"></i>
                                </div>
                                <p class="text-green-500 text-xs font-medium mt-2">Visualizar de Hoje</p>
                            </div>
                        </div>
                    @else
                        <!-- New Questionnaire Button -->
                        <div
                            wire:click="redirectToDailyReportForm"
                            class="border border-dashed border-orange-400/60 hover:cursor-pointer hover:bg-orange-400/10 transition-all duration-300 rounded-lg p-3 mb-4">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-12 w-12 bg-orange-500/10 rounded-xl flex items-center justify-center">
                                    <i
                                        wire:loading.remove wire:target="redirectToDailyReportForm"
                                        class="fad fa-plus-circle text-orange-500 text-xl"></i>
                                    <i
                                        wire:loading wire:target="redirectToDailyReportForm"
                                        class="fad fa-spinner fa-spin text-orange-500 text-xl"></i>
                                </div>
                                <p class="text-orange-500 text-xs font-medium mt-2">Novo Questionário</p>
                            </div>
                        </div>
                    @endif

                    <!-- Latest Reports -->
                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Últimas 5 respostas</h4>
                        @if($dailyReports && count($dailyReports) > 0)
                            @foreach($dailyReports as $report)
                                <div wire:click="viewDailyReport({{ $report->par_id }})" class="flex items-center hover:cursor-pointer bg-gray-50 rounded-lg p-3 border border-gray-200 transition-all duration-200 hover:shadow-md">
                                    <div class="w-8 h-8 rounded-lg bg-orange-500/10 flex items-center justify-center mr-3">
                                        <i class="fad fa-clipboard-prescription text-sm text-orange-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-bold text-orange-500">{{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-600 text-center">Nenhum registro</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- FIQR Reports Section -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                                <i class="fad fa-clipboard-check text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Questionários FIQR</h3>
                                <p class="text-sm text-gray-500">Avaliação de impacto</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center my-6">
                        <div class="grow h-px bg-gray-300/60"></div>
                    </div>

                    <!-- FIQR Status -->
                    @if($currentFiqrReport)
                        <div wire:click="viewFiqrReport({{ $currentFiqrReport->par_id }})"
                                class="flex items-center justify-between hover:cursor-pointer rounded-lg p-3 transition-all duration-200 bg-green-50 border border-green-300 mb-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded flex items-center justify-center mr-3 bg-green-500/20">
                                    <i class="fad fa-check-circle text-green-500"></i>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700 block">Último FIQR Completo</span>
                                    <span class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($currentFiqrReport->par_period_starts)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                            <i class="fad fa-chevron-right text-green-600"></i>
                        </div>
                    @else
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <p class="text-xs text-blue-700 text-center">Você ainda não possui questionários FIQR</p>
                        </div>
                    @endif

                    <!-- Latest Reports -->
                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Últimos 5 períodos</h4>
                        @if($fiqrReports && count($fiqrReports) > 0)
                            @foreach($fiqrReports as $report)
                                <div class="flex items-center bg-gray-50 rounded-lg p-3 border border-gray-200">
                                    <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center mr-3">
                                        <i class="fad fa-clipboard-check text-sm text-blue-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-bold text-blue-500">
                                            {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m') }}
                                            @if($report->par_period_end)
                                                - {{ \Carbon\Carbon::parse($report->par_period_end)->format('d/m') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-600 text-center">Nenhum registro</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Appointments Section -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-green-500/10 rounded-lg px-4 py-3 mr-3">
                                <i class="fad fa-stethoscope text-green-500 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Consultas Médicas</h3>
                                <p class="text-sm text-gray-500">Acompanhamento médico</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center my-6">
                        <div class="grow h-px bg-gray-300/60"></div>
                    </div>

                    @if($todayAppointment)
                        <!-- Already Filled Today Warning -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <div class="shrink-0">
                                    <i class="fad fa-exclamation-triangle text-yellow-500 mr-2 text-lg"></i>
                                </div>
                                <div class="ml-2">
                                    <p class="text-xs text-yellow-800">
                                        <strong>Atenção:</strong> Consulta de hoje já registrada.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- View Today's Appointment Button -->
                        <div
                            wire:click="viewAppointment({{ $todayAppointment->app_id }})"
                            class="border border-dashed border-green-400/60 hover:cursor-pointer hover:bg-green-400/10 transition-all duration-300 rounded-lg p-3 mb-4">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-12 w-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                                    <i
                                        wire:loading.remove wire:target="viewAppointment({{ $todayAppointment->app_id }})"
                                        class="fad fa-eye text-green-500 text-xl"></i>
                                    <i
                                        wire:loading wire:target="viewAppointment({{ $todayAppointment->app_id }})"
                                        class="fad fa-spinner fa-spin text-green-500 text-xl"></i>
                                </div>
                                <p class="text-green-500 text-xs font-medium mt-2">Visualizar de Hoje</p>
                            </div>
                        </div>
                    @else
                        <!-- New Appointment Button -->
                        <div
                            wire:click="redirectToAppointmentForm"
                            class="border border-dashed border-green-400/60 hover:cursor-pointer hover:bg-green-400/10 transition-all duration-300 rounded-lg p-3 mb-4">
                            <div class="flex flex-col items-center justify-center">
                                <div class="h-12 w-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                                    <i
                                        wire:loading.remove wire:target="redirectToAppointmentForm"
                                        class="fad fa-plus-circle text-green-500 text-xl"></i>
                                    <i
                                        wire:loading wire:target="redirectToAppointmentForm"
                                        class="fad fa-spinner fa-spin text-green-500 text-xl"></i>
                                </div>
                                <p class="text-green-500 text-xs font-medium mt-2">Nova Consulta</p>
                            </div>
                        </div>
                    @endif

                    <!-- Latest Appointments -->
                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold text-gray-700 mb-2">Últimas 5 consultas</h4>
                        @if($appointments && count($appointments) > 0)
                            @foreach($appointments as $appointment)
                                <div wire:click="viewAppointment({{ $appointment->app_id }})" class="flex items-center hover:cursor-pointer bg-gray-50 rounded-lg p-3 border border-gray-200 transition-all duration-200 hover:shadow-md">
                                    <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center mr-3">
                                        <i class="fad fa-stethoscope text-sm text-green-500"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-bold text-green-500">{{ \Carbon\Carbon::parse($appointment->app_date)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <p class="text-xs text-gray-600 text-center">Nenhum registro</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
