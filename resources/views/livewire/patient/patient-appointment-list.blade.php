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
                                <div class="bg-green-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-stethoscope text-green-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Consultas Médicas</h3>
                                    <p class="text-sm text-gray-500">Acompanhamento de consultas médicas</p>
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
                                        <p class="text-sm text-yellow-800">
                                            <strong>Atenção:</strong> Você já registrou uma consulta hoje. Não é possível registrar mais consultas na mesma data.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- View Today's Appointment Button -->
                            <div
                                wire:click="viewAppointment({{ $todayAppointment->app_id }})"
                                class="border border-dashed border-green-400/60 hover:cursor-pointer hover:bg-green-400/10 transition-all duration-300 rounded-lg p-3 mt-2 flex-1">
                                <div class="flex flex-col items-center justify-center h-full min-h-[120px]">
                                    <div class="h-16 w-16 bg-green-500/10 rounded-xl flex items-center justify-center">
                                        <i
                                            wire:loading.remove wire:target="viewAppointment({{ $todayAppointment->app_id }})"
                                            class="fad fa-eye text-green-500 text-3xl"></i>
                                        <i
                                            wire:loading wire:target="viewAppointment({{ $todayAppointment->app_id }})"
                                            class="fad fa-spinner fa-spin text-green-500 text-3xl"></i>
                                    </div>
                                    <p class="text-green-500 text-md font-medium mt-3">Visualizar Consulta de Hoje</p>
                                </div>
                            </div>
                        @else
                            <!-- Info Message -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="fad fa-info-circle text-blue-500 mr-2"></i>
                                    <p class="text-sm text-blue-700">
                                        <strong>Informação:</strong> Registre suas consultas médicas para acompanhar sua saúde.
                                    </p>
                                </div>
                            </div>

                            <!-- New Appointment Button -->
                            <div
                                wire:click="redirectToAppointmentForm"
                                class="border border-dashed border-green-400/60 hover:cursor-pointer hover:bg-green-400/10 transition-all duration-300 rounded-lg p-3 mt-6 flex-1">
                                <div class="flex flex-col items-center justify-center h-full min-h-[120px]">
                                    <div class="h-16 w-16 bg-green-500/10 rounded-xl flex items-center justify-center">
                                        <i
                                            wire:loading.remove wire:target="redirectToAppointmentForm"
                                            class="fad fa-plus-circle text-green-500 text-3xl"></i>
                                        <i
                                            wire:loading wire:target="redirectToAppointmentForm"
                                            class="fad fa-spinner fa-spin text-green-500 text-3xl"></i>
                                    </div>
                                    <p class="text-green-500 text-md font-medium mt-3">Clique para registrar a consulta</p>
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
                                <div class="bg-green-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-clock text-green-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Últimas Consultas</h3>
                                    <p class="text-sm text-gray-500">Últimas 10 consultas registradas</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center my-6">
                            <div class="grow h-px bg-gray-300/60"></div>
                        </div>

                        @if($appointments && count($appointments) > 0)
                            @foreach($appointments as $appointment)
                                <div wire:click="viewAppointment({{ $appointment->app_id }})" class="flex flex-row justify-between mt-6 hover:cursor-pointer bg-white rounded-lg shadow-md w-full p-6 border border-gray-200 transition-all duration-200 hover:shadow-lg">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 rounded-lg bg-green-500/10 border border-green-200 flex items-center justify-center">
                                            <i class="fad fa-stethoscope text-2xl text-green-500"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-500">Consulta Médica</h4>
                                            <span class="text-md font-bold text-green-500">{{ \Carbon\Carbon::parse($appointment->app_date)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fad fa-info-circle text-gray-400 mr-2"></i>
                                    <p class="text-sm text-gray-600">
                                        Nenhuma consulta encontrada ainda.
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
