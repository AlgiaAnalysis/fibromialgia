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
            <div class="grid grid-cols-3 gap-6 mt-8">
                <!-- Large Line Chart Card (2 columns) -->
                <div class="col-span-2 bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="flex flex-col p-6 h-full">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-clipboard-check text-blue-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Questionários FIQR</h3>
                                    <p class="text-sm text-gray-500">Avaliação de impacto da fibromialgia</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center my-6">
                            <div class="grow h-px bg-gray-300/60"></div>
                        </div>

                        @if($currentFiqrReport)
                            <!-- Period Info -->
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <div class="bg-white/20 rounded-lg px-3 py-2 mr-3">
                                        <i class="fad fa-calendar-week text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-semibold text-white">Período Atual</h4>
                                        <p class="text-sm text-blue-100">
                                            {{ \Carbon\Carbon::parse($currentFiqrReport->par_period_starts)->format('d/m/Y') }}
                                            até
                                            {{ \Carbon\Carbon::parse($currentFiqrReport->par_period_end)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Week Days -->
                            <div class="mb-4">
                                <h4 class="text-base font-semibold text-gray-700 mb-3">Selecione o dia para preencher:</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach($weekDays as $index => $day)
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
                                            $dayName = $dayNames[$day] ?? $day;
                                            $isFilled = isset($dayStatuses[$day]) && $dayStatuses[$day];
                                            $isSunday = $day === 'Sunday';
                                        @endphp
                                        <div wire:click="viewReportDay({{ $currentFiqrReport->par_id }}, '{{ $day }}')"
                                             class="hover:cursor-pointer border rounded-lg p-4 transition-all duration-200 hover:shadow-md
                                             {{ $isFilled
                                                 ? 'bg-green-50 border-green-300 hover:bg-green-100'
                                                 : 'bg-blue-50 border-blue-200 hover:bg-blue-100' }}
                                             {{ $isSunday ? 'col-span-2' : '' }}">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 {{ $isFilled ? 'bg-green-500/20' : 'bg-blue-500/20' }}">
                                                        <i
                                                            wire:loading.remove wire:target="viewReportDay({{ $currentFiqrReport->par_id }}, '{{ $day }}')"
                                                            class="fad {{ $isFilled ? 'fa-check-circle' : 'fa-calendar-day' }} {{ $isFilled ? 'text-green-500' : 'text-blue-500' }}"></i>
                                                        <i
                                                            wire:loading wire:target="viewReportDay({{ $currentFiqrReport->par_id }}, '{{ $day }}')"
                                                            class="fad fa-spinner fa-spin text-blue-500 text-xl"></i>
                                                    </div>
                                                    <div>
                                                        <span class="font-medium text-gray-700 block">{{ $dayName }}</span>
                                                        <span class="text-xs {{ $isFilled ? 'text-green-600' : 'text-orange-600' }} font-medium">
                                                            {{ $isFilled ? '✓ Preenchido' : '⏳ Pendente' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <i class="fad fa-chevron-right text-blue-500"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Info Message -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-center">
                                    <i class="fad fa-info-circle text-blue-500 mr-2"></i>
                                    <p class="text-sm text-blue-700">
                                        <strong>Informação:</strong> Nenhum questionário FIQR disponível no momento.
                                    </p>
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
                                <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-clock text-blue-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Histórico</h3>
                                    <p class="text-sm text-gray-500">Últimos 10 períodos</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center my-6">
                            <div class="grow h-px bg-gray-300/60"></div>
                        </div>

                        @if($fiqrReports && count($fiqrReports) > 0)
                            @foreach($fiqrReports as $report)
                                <div class="flex flex-row justify-between mt-4 bg-white rounded-lg shadow-md w-full p-4 border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg bg-blue-500/10 border border-blue-200 flex items-center justify-center">
                                            <i class="fad fa-clipboard-check text-lg text-blue-500"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h4 class="text-xs font-medium text-gray-500">FIQR</h4>
                                            <span class="text-sm font-bold text-blue-500">
                                                {{ \Carbon\Carbon::parse($report->par_period_starts)->format('d/m') }}
                                                @if($report->par_period_end)
                                                    - {{ \Carbon\Carbon::parse($report->par_period_end)->format('d/m') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fad fa-info-circle text-gray-400 mr-2"></i>
                                    <p class="text-xs text-gray-600">
                                        Nenhum histórico encontrado.
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
