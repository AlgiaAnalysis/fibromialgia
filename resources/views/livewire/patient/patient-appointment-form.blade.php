<div class="py-8 pt-4">
    <div class="w-full">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="bg-purple-500/10 rounded-lg px-5 py-4 mr-3">
                    <i class="fad fa-stethoscope text-purple-500 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-purple-500/80">Consulta Médica</h3>
                    @if($isViewMode && $existingAppointment)
                        <p class="text-sm text-gray-500">Visualização da consulta de {{ \Carbon\Carbon::parse($existingAppointment->app_date)->format('d/m/Y') }}</p>
                    @else
                        <p class="text-sm text-gray-500">Preencha os dados da consulta para a data de {{ date('d/m/Y') }}</p>
                    @endif
                </div>
            </div>
        </div>

        @if($isViewMode)
            <!-- View Mode Alert -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="shrink-0">
                        <i class="fad fa-eye text-yellow-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            <strong>Modo de Visualização:</strong> Você está visualizando uma consulta já registrada. Esta visualização é apenas para consulta.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Questions List -->
        @if($questions && count($questions) > 0)
            <div class="space-y-6">
                @foreach($questions as $question)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 relative">
                        <!-- Question Name -->
                        <div class="mb-4 flex items-center">
                            <div class="bg-purple-500/10 rounded-lg px-3 py-2 mr-3">
                                <i class="fad fa-question-circle text-purple-500 text-xl"></i>
                            </div>
                            <h4 class="text-base font-semibold text-gray-800">{{ $question->que_name }}</h4>
                        </div>

                        <!-- Question Index Badge -->
                        <div class="absolute top-6 right-6">
                            <span class="bg-purple-100 text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">
                                #{{ $question->que_index }}
                            </span>
                        </div>

                        <!-- Answer Text Area -->
                        <div class="mt-6">
                            <textarea
                                @if($isViewMode) disabled @endif
                                wire:model="answers.{{ $question->que_id }}"
                                wire:change="updateAnswer({{ $question->que_id }}, $event.target.value)"
                                rows="4"
                                class="w-full px-4 py-3 border-2 rounded-lg transition-all duration-200 resize-vertical
                                    focus:outline-none focus:ring-2 focus:ring-purple-200
                                    @if(!$isViewMode) border-gray-300 focus:border-purple-500 @else border-gray-200 bg-gray-50 opacity-75 cursor-not-allowed @endif">
                            </textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fad fa-info-circle text-blue-500 mr-2"></i>
                    <p class="text-sm text-blue-700">
                        Nenhuma pergunta encontrada.
                    </p>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            @if($isViewMode)
                <!-- Only Back Button in View Mode -->
                <button
                    wire:click="goBack"
                    wire:loading.attr="disabled"
                    class="w-full px-6 py-4 hover:cursor-pointer bg-white border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 font-semibold rounded-lg transition-all duration-200 flex items-center justify-center disabled:opacity-50">
                    <i class="fad fa-arrow-left mr-2" wire:loading.remove wire:target="goBack"></i>
                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="goBack"></i>
                    <span wire:loading.remove wire:target="goBack">Voltar</span>
                    <span wire:loading wire:target="goBack">Voltando...</span>
                </button>
            @else
                <!-- Back Button -->
                <button
                    wire:click="goBack"
                    wire:loading.attr="disabled"
                    class="flex-1 px-6 py-4 hover:cursor-pointer bg-white border-2 border-gray-300 text-gray-700 hover:bg-gray-50 hover:border-gray-400 font-semibold rounded-lg transition-all duration-200 flex items-center justify-center disabled:opacity-50">
                    <i class="fad fa-arrow-left mr-2" wire:loading.remove wire:target="goBack"></i>
                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="goBack"></i>
                    <span wire:loading.remove wire:target="goBack">Voltar</span>
                    <span wire:loading wire:target="goBack">Voltando...</span>
                </button>

                <!-- Submit Button -->
                <button
                    wire:click="submitForm"
                    wire:loading.attr="disabled"
                    class="flex-1 px-6 py-4 hover:cursor-pointer bg-purple-500 text-white hover:bg-purple-600 font-semibold rounded-lg transition-all duration-200 flex items-center justify-center disabled:opacity-50 shadow-md">
                    <i class="fad fa-paper-plane mr-2" wire:loading.remove wire:target="submitForm"></i>
                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="submitForm"></i>
                    <span wire:loading.remove wire:target="submitForm">Registrar Consulta</span>
                    <span wire:loading wire:target="submitForm">Registrando...</span>
                </button>
            @endif
        </div>
    </div>
</div>
