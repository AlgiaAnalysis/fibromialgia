<div class="py-8 pt-4">
    <div class="w-full">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <div class="bg-blue-500/10 rounded-lg px-5 py-4 mr-3">
                    <i class="fad fa-clipboard-check text-blue-500 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-500/80">Questionário FIQR</h3>
                    @php
                        $dayNames = [
                            'Monday' => 'Segunda-feira',
                            'Tuesday' => 'Terça-feira',
                            'Wednesday' => 'Quarta-feira',
                            'Thursday' => 'Quinta-feira',
                            'Friday' => 'Sexta-feira',
                            'Saturday' => 'Sábado',
                            'Sunday' => 'Domingo'
                        ];
                        $dayName = $dayNames[$weekday] ?? $weekday;
                    @endphp
                    @if($isViewMode && $existingReport)
                        <p class="text-sm text-gray-500">Visualização do {{ $dayName }}</p>
                    @else
                        <p class="text-sm text-gray-500">Preencha o questionário para {{ $dayName }}</p>
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
        @endif

        <!-- Questions List by Domain -->
        @if($questionsByDomain && count($questionsByDomain) > 0)
            <div class="space-y-8">
                @foreach($questionsByDomain as $domainKey => $domain)
                    <!-- Domain Separator -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md p-6">
                        <div class="flex items-center mb-2">
                            <div class="bg-white/20 rounded-lg px-4 py-3 mr-3">
                                <i class="fad fa-layer-group text-white text-2xl"></i>
                            </div>
<div>
                                <h3 class="text-xl font-bold text-white">{{ $domain['name'] }}</h3>
                                <p class="text-sm text-blue-100">{{ $domain['description'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Questions for this domain -->
                    <div class="space-y-6">
                        @foreach($domain['questions'] as $question)
                            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 relative">
                                <!-- Question Name -->
                                <div class="mb-4 flex items-center">
                                    <div class="bg-blue-500/10 rounded-lg px-3 py-2 mr-3">
                                        <i class="fad fa-question-circle text-blue-500 text-xl"></i>
                                    </div>
                                    <h4 class="text-base font-semibold text-gray-800">{{ $question->que_name }}</h4>
                                </div>

                                <!-- Question Index Badge -->
                                <div class="absolute top-6 right-6">
                                    <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full">
                                        #{{ $question->que_index }}
                                    </span>
                                </div>

                                <!-- Answer Options for the selected day -->
                                <div class="mt-6">
                                    <!-- 0-10 scale buttons -->
                                    <div class="grid grid-cols-11 gap-2">
                                        @for($i = 0; $i <= 10; $i++)
                                            <button
                                                @if($isViewMode) disabled @else wire:click="selectAnswer('{{ $domainKey }}', {{ $question->que_id }}, {{ $i }})" @endif
                                                class="px-3 py-4 rounded-lg border-2 transition-all duration-200
                                                    {{ isset($answers[$domainKey][$question->que_id]) && $answers[$domainKey][$question->que_id] == $i
                                                        ? 'bg-blue-500 border-blue-500 text-white shadow-md'
                                                        : 'bg-white border-gray-300 text-gray-700' }}
                                                    @if(!$isViewMode) hover:text-blue-500 hover:cursor-pointer hover:border-blue-500 hover:bg-blue-50 @else opacity-75 cursor-not-allowed @endif">
                                                <span class="text-lg font-semibold">{{ $i }}</span>
                                            </button>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Domain Separator Bottom -->
                    <div class="flex items-center my-8">
                        <div class="grow h-px bg-gray-300"></div>
                        <div class="mx-4 text-gray-400">
                            <i class="fad fa-layer-group text-2xl"></i>
                        </div>
                        <div class="grow h-px bg-gray-300"></div>
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
                    class="flex-1 px-6 py-4 hover:cursor-pointer bg-blue-500 text-white hover:bg-blue-600 font-semibold rounded-lg transition-all duration-200 flex items-center justify-center disabled:opacity-50 shadow-md">
                    <i class="fad fa-paper-plane mr-2" wire:loading.remove wire:target="submitForm"></i>
                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="submitForm"></i>
                    <span wire:loading.remove wire:target="submitForm">Enviar Questionário FIQR</span>
                    <span wire:loading wire:target="submitForm">Enviando...</span>
                </button>
            @endif
        </div>
    </div>
</div>
