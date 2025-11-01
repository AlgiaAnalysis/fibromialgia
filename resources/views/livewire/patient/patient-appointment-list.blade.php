<div class="py-8 pt-4">
    <div class="w-full">
        <div class="mt-4">
            <!-- Main Appointment Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 mb-6">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center">
                            <div class="bg-purple-500/10 rounded-xl px-5 py-4 mr-4">
                                <i class="fad fa-stethoscope text-purple-500 text-3xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Consultas Médicas</h2>
                                <p class="text-sm text-gray-500 mt-1">Acompanhamento de consultas médicas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Alert -->
                    @if($todayAppointment)
                        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-5 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fad fa-check-circle text-green-500 text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-green-800 mb-1">Consulta de Hoje Registrada</h3>
                                    <p class="text-sm text-green-700">
                                        Você já registrou uma consulta hoje ({{ \Carbon\Carbon::parse($todayAppointment->app_date)->format('d/m/Y') }}). Não é possível registrar mais consultas na mesma data.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- View Today's Appointment Button -->
                        <button
                            wire:click="viewAppointment({{ $todayAppointment->app_id }})"
                            wire:loading.attr="disabled"
                            class="w-full hover:cursor-pointer bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-purple-600 hover:to-purple-700 flex items-center justify-center disabled:opacity-50">
                            <i class="fad fa-eye mr-3 text-xl" wire:loading.remove wire:target="viewAppointment({{ $todayAppointment->app_id }})"></i>
                            <i class="fad fa-spinner fa-spin mr-3 text-xl" wire:loading wire:target="viewAppointment({{ $todayAppointment->app_id }})"></i>
                            <span wire:loading.remove wire:target="viewAppointment({{ $todayAppointment->app_id }})">Visualizar Consulta de Hoje</span>
                            <span wire:loading wire:target="viewAppointment({{ $todayAppointment->app_id }})">Carregando...</span>
                        </button>
                    @else
                        <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-5 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fad fa-info-circle text-blue-500 text-2xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-semibold text-blue-800 mb-1">Nenhuma Consulta Registrada Hoje</h3>
                                    <p class="text-sm text-blue-700">
                                        Você ainda não registrou uma consulta hoje. Registre suas consultas médicas para acompanhar sua saúde.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- New Appointment Button -->
                        <button
                            wire:click="redirectToAppointmentForm"
                            wire:loading.attr="disabled"
                            class="w-full hover:cursor-pointer bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold py-4 px-6 rounded-lg transition-all duration-200 hover:shadow-lg hover:from-purple-600 hover:to-purple-700 flex items-center justify-center disabled:opacity-50">
                            <i class="fad fa-plus-circle mr-3 text-xl" wire:loading.remove wire:target="redirectToAppointmentForm"></i>
                            <i class="fad fa-spinner fa-spin mr-3 text-xl" wire:loading wire:target="redirectToAppointmentForm"></i>
                            <span wire:loading.remove wire:target="redirectToAppointmentForm">Registrar Nova Consulta</span>
                            <span wire:loading wire:target="redirectToAppointmentForm">Carregando...</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- History Card -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex items-center mb-6">
                        <div class="bg-purple-500/10 rounded-xl px-4 py-3 mr-4">
                            <i class="fad fa-clock text-purple-500 text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Histórico de Consultas</h3>
                            <p class="text-sm text-gray-500">Últimas consultas registradas</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        @if($appointments && count($appointments) > 0)
                            <div class="space-y-4">
                                @foreach($appointments as $appointment)
                                    <div wire:click="viewAppointment({{ $appointment->app_id }})"
                                         class="hover:cursor-pointer bg-gray-50 hover:bg-purple-50 border border-gray-200 hover:border-purple-300 rounded-lg p-5 transition-all duration-200 hover:shadow-md">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <div class="w-14 h-14 bg-purple-500/10 rounded-xl flex items-center justify-center mr-4">
                                                    <i
                                                        wire:loading.remove wire:target="viewAppointment({{ $appointment->app_id }})"
                                                        class="fad fa-stethoscope text-purple-500 text-2xl"></i>
                                                    <i wire:loading wire:target="viewAppointment({{ $appointment->app_id }})"
                                                        class="fad fa-spinner fa-spin text-purple-500 text-2xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <h4 class="text-base font-semibold text-gray-800">
                                                            Consulta Médica
                                                        </h4>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fad fa-calendar-day text-gray-400 mr-2 text-sm"></i>
                                                        <span class="text-sm text-gray-600">
                                                            {{ \Carbon\Carbon::parse($appointment->app_date)->format('d/m/Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <i class="fad fa-chevron-right text-purple-400 text-xl"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fad fa-stethoscope text-gray-400 text-3xl"></i>
                                </div>
                                <p class="text-gray-600 font-medium mb-1">Nenhuma consulta encontrada</p>
                                <p class="text-sm text-gray-500">Comece registrando sua primeira consulta acima</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
