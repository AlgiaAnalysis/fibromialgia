<div class="py-8 pt-4">
    <div class="w-full">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="bg-orange-500/10 rounded-lg px-5 py-4 mr-3">
                    <i class="fad fa-clipboard-prescription text-orange-500 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-orange-500/80">Questionário Diário</h3>
                    @if($isViewMode && $existingReport)
                        <p class="text-sm text-gray-500">Visualização do questionário de {{ \Carbon\Carbon::parse($existingReport->par_period_starts)->format('d/m/Y') }}</p>
                    @else
                        <p class="text-sm text-gray-500">Preencha o questionário para a data de {{ date('d/m/Y') }}</p>
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
                            <strong>Modo de Visualização:</strong> Você está visualizando um questionário já preenchido. Esta visualização é apenas para consulta.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Score Card -->
            @if($existingReport && $existingReport->par_score !== null)
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 mb-8 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-lg px-4 py-3 mr-4">
                                <i class="fad fa-chart-line text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-orange-100 mb-1">Score do Questionário</h4>
                                <p class="text-xs text-orange-200">Pontuação total</p>
                            </div>
                        </div>
                        <span class="text-4xl font-bold">{{ number_format($existingReport->par_score, 0) }}</span>
                    </div>
                </div>
            @endif

            <!-- Medication Prescription Card -->
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-8">
                <div class="flex items-center mb-4">
                    <div class="bg-green-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-pills text-green-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Medicamentos Prescritos</h3>
                        <p class="text-sm text-gray-500">Prescrições médicas para este questionário</p>
                    </div>
                </div>

                @if($existingReport && $existingReport->par_medication && trim($existingReport->par_medication) !== '')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="shrink-0">
                                <i class="fad fa-check-circle text-green-500 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $existingReport->par_medication }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="shrink-0">
                                <i class="fad fa-info-circle text-gray-400 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-gray-600 font-medium">Nenhum medicamento foi prescrito ainda para este questionário.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Questions List -->
        @if($questions && count($questions) > 0)
            <div class="space-y-6">
                @foreach($questions as $question)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 relative">
                        <!-- Question Name -->
                        <div class="mb-4 flex items-center">
                            <div class="bg-orange-500/10 rounded-lg px-3 py-2 mr-3">
                                <i class="fad fa-question-circle text-orange-500 text-xl"></i>
                            </div>
                            <h4 class="text-base font-semibold text-gray-800">{{ $question->que_name }}</h4>
                        </div>

                        <!-- Question Index Badge -->
                        <div class="absolute bottom-4 right-4">
                            <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full">
                                #{{ $question->que_index }}
                            </span>
                        </div>

                        <!-- Answer Options -->
                        @if($question->que_id == 52)
                            <!-- Sim/Não buttons -->
                            <div class="flex gap-4 mb-8">
                                <button
                                    @if($isViewMode) disabled @else wire:click="selectAnswer({{ $question->que_id }}, 1)" @endif
                                    class="flex-1 px-6 py-4 rounded-lg border-2 transition-all duration-200
                                        {{ isset($answers[$question->que_id]) && $answers[$question->que_id] == 1
                                            ? 'bg-orange-500 border-orange-500 text-white shadow-md'
                                            : 'bg-white border-gray-300 text-gray-700' }}
                                        @if(!$isViewMode) hover:text-orange-500 hover:cursor-pointer hover:border-orange-500 hover:bg-orange-50 @else opacity-75 cursor-not-allowed @endif">
                                    <div class="flex flex-col items-center">
                                        <i class="fad fa-check-circle text-3xl mb-2"></i>
                                        <span class="font-semibold">Sim</span>
                                    </div>
                                </button>

                                <button
                                    @if($isViewMode) disabled @else wire:click="selectAnswer({{ $question->que_id }}, -1)" @endif
                                    class="flex-1 px-6 py-4 rounded-lg border-2 transition-all duration-200
                                        {{ isset($answers[$question->que_id]) && $answers[$question->que_id] == -1
                                            ? 'bg-red-500 border-red-500 text-white shadow-md'
                                            : 'bg-white border-gray-300 text-gray-700' }}
                                        @if(!$isViewMode) hover:text-red-500 hover:cursor-pointer hover:border-red-500 hover:bg-red-50 @else opacity-75 cursor-not-allowed @endif">
                                    <div class="flex flex-col items-center">
                                        <i class="fad fa-times-circle text-3xl mb-2"></i>
                                        <span class="font-semibold">Não</span>
                                    </div>
                                </button>
                            </div>
                        @else
                            <!-- 0-10 scale buttons -->
                            <div class="grid grid-cols-6 md:grid-cols-11 gap-2 mb-8">
                                @for($i = 0; $i <= 10; $i++)
                                    <button
                                        @if($isViewMode) disabled @else wire:click="selectAnswer({{ $question->que_id }}, {{ $i }})" @endif
                                        class="px-2 py-3 md:px-3 md:py-4 rounded-lg border-2 transition-all duration-200
                                            {{ isset($answers[$question->que_id]) && $answers[$question->que_id] == $i
                                                ? 'bg-orange-500 border-orange-500 text-white shadow-md'
                                                : 'bg-white border-gray-300 text-gray-700' }}
                                            @if(!$isViewMode) hover:text-orange-500 hover:cursor-pointer hover:border-orange-500 hover:bg-orange-50 @else opacity-75 cursor-not-allowed @endif">
                                        <span class="text-base md:text-lg font-semibold">{{ $i }}</span>
                                    </button>
                                @endfor
                            </div>
                        @endif
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
                    class="flex-1 px-6 py-4 hover:cursor-pointer bg-orange-500 text-white hover:bg-orange-600 font-semibold rounded-lg transition-all duration-200 flex items-center justify-center disabled:opacity-50 shadow-md">
                    <i class="fad fa-paper-plane mr-2" wire:loading.remove wire:target="submitForm"></i>
                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="submitForm"></i>
                    <span wire:loading.remove wire:target="submitForm">Enviar Formulário</span>
                    <span wire:loading wire:target="submitForm">Enviando...</span>
                </button>
            @endif
        </div>
    </div>
</div>
