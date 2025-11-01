<div class="py-8 pt-4">
    <div class="w-full">
        <div class="flex flex-row items-start justify-start">
            <div class="h-12 w-12 bg-bg-blue-500/80 rounded-lg flex items-center justify-center">
                <div class="flex flex-col items-center">
                    <i class="fad fa-user-injured text-2xl text-blue-500/80"></i>
                </div>
            </div>

            <div class="flex flex-col items-start justify-start">
                <h3 class="text-xl font-bold text-blue-500/80">Olá, {{ auth()->user()->usr_name }}!</h3>
                <p class="text-gray-500/80 font-medium text-sm">Bem-vindo ao seu dashboard de saúde!</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mt-6">
            <button wire:click="goToDailyReportList" class="block w-full">
                <div class="bg-orange-200/60 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-4 flex flex-row items-center justify-start">
                        <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <i wire:loading.remove wire:target="goToDailyReportList"
                                    class="fad fa-calendar text-2xl text-orange-500/80"></i>
                                <i wire:loading wire:target="goToDailyReportList"
                                    class="fad fa-spinner fa-spin text-2xl text-orange-500/80"></i>
                            </div>
                        </div>

                        <div class="ml-4 flex flex-col items-start justify-start">
                            <span class="text-orange-500/80 font-medium">Questionários Diário</span>
                            <span class="text-gray-500/80 font-medium text-xs">Quantidade de Envios: {{ $dailyReportsCount }}</span>
                        </div>
                    </div>
                </div>
            </button>

            <button wire:click="goToFiqrReportList" class="block w-full">
                <div class="bg-blue-200/60 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-4 flex flex-row items-center justify-start">
                        <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <i wire:loading.remove wire:target="goToFiqrReportList"
                                    class="fad fa-clipboard-prescription text-2xl text-blue-500/80"></i>
                                <i wire:loading wire:target="goToFiqrReportList"
                                    class="fad fa-spinner fa-spin text-2xl text-blue-500/80"></i>
                            </div>
                        </div>

                        <div class="ml-4 flex flex-col items-start justify-start">
                            <span class="text-blue-500/80 font-medium">FIQR</span>
                            <span class="text-gray-500/80 font-medium text-xs">Quantidade de Envios: {{ $fiqrReportsCount }}</span>
                        </div>
                    </div>
                </div>
            </button>

            <button wire:click="goToAppointmentList" class="block w-full">
                <div class="bg-purple-200/60 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-4 flex flex-row items-center justify-start">
                        <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <i wire:loading.remove wire:target="goToAppointmentList"
                                    class="fad fa-stethoscope text-2xl text-purple-500/80"></i>
                                <i wire:loading wire:target="goToAppointmentList"
                                    class="fad fa-spinner fa-spin text-2xl text-purple-500/80"></i>
                            </div>
                        </div>

                        <div class="ml-4 flex flex-col items-start justify-start">
                            <span class="text-purple-500/80 font-medium">Consultas</span>
                            <span class="text-gray-500/80 font-medium text-xs">Total de Consultas: {{ $appointmentsCount }}</span>
                        </div>
                    </div>
                </div>
            </button>
        </div>

        <div class="flex items-center my-8">
            <div class="flex-grow h-px bg-gray-300"></div>
                <div class="mx-6">
                    <i class="fad fa-heartbeat text-gray-400 text-2xl"></i>
                </div>
            <div class="flex-grow h-px bg-gray-300"></div>
        </div>

        <!-- Charts Section -->
        <div class="mt-8">
            <!-- First Row: Large Line Chart + Circular Progress -->
            <div class="grid grid-cols-3 gap-6 mb-6">
                <!-- Large Line Chart Card (2 columns) -->
                <div class="col-span-2 bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-orange-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-chart-line text-orange-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Score Questionários Diários</h3>
                                    <p class="text-sm text-gray-500">Últimos 7 questionários</p>
                                </div>
                            </div>
                        </div>
                        <div class="h-64 flex items-center justify-center">
                            <canvas id="painChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Circular Progress Card (1 column) -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6 flex flex-col items-center justify-center h-full">
                        <div class="w-40 h-40 relative">
                            @php
                                // Circunferência do círculo: 2 * π * r = 2 * π * 70 ≈ 439.82
                                $circumference = 439.82;
                                // Score de 0 a 100, calcular o offset
                                // Score 0 = offset 439.82 (círculo vazio)
                                // Score 100 = offset 0 (círculo completo)
                                $scorePercentage = min(100, max(0, $lastDailyReportScore)); // Garantir que está entre 0 e 100
                                $strokeOffset = $circumference - ($circumference * $scorePercentage / 100);
                            @endphp
                            <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 160 160">
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="10" fill="transparent" class="text-gray-200"></circle>
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="10" fill="transparent"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $strokeOffset }}"
                                    class="text-orange-500 transition-all duration-500"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-4xl font-bold text-gray-800">{{ number_format($lastDailyReportScore, 0) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <p class="text-lg font-semibold text-gray-800">Score de Hoje</p>
                            <p class="text-sm text-gray-500">de 0 a 100</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center my-8">
                <div class="flex-grow h-px bg-gray-300"></div>
                    <div class="mx-6">
                        <i class="fad fa-chart-line text-gray-400 text-2xl"></i>
                    </div>
                <div class="flex-grow h-px bg-gray-300"></div>
            </div>

            <!-- Second Row: Question Charts -->
            @if($questionCharts && count($questionCharts) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($questionCharts as $index => $questionChart)
                        @php
                            $colors = [
                                ['bg' => 'bg-blue-500/10', 'icon' => 'fa-moon', 'text' => 'text-blue-500'],
                                ['bg' => 'bg-purple-500/10', 'icon' => 'fa-tired', 'text' => 'text-purple-500'],
                                ['bg' => 'bg-green-500/10', 'icon' => 'fa-heart', 'text' => 'text-green-500'],
                                ['bg' => 'bg-red-500/10', 'icon' => 'fa-exclamation-triangle', 'text' => 'text-red-500'],
                            ];
                            $color = $colors[$index % count($colors)];
                            $chartId = 'questionChart' . $questionChart['id'];
                        @endphp
                        <div class="bg-white rounded-lg shadow-md border border-gray-200">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center">
                                        <div class="{{ $color['bg'] }} rounded-lg px-4 py-3 mr-3">
                                            <i class="fad {{ $color['icon'] }} {{ $color['text'] }} text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $questionChart['name'] }}</h3>
                                            <p class="text-sm text-gray-500">Últimos 7 questionários</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="h-48 flex items-center justify-center">
                                    <canvas id="{{ $chartId }}" class="w-full h-full"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pain Chart - Daily Reports Scores
        const painCtx = document.getElementById('painChart');
        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);
        
        new Chart(painCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Score',
                    data: chartData,
                    borderColor: 'rgb(249, 115, 22)',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    tension: 0.4,
                    fill: true,
                    spanGaps: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.parsed.y === null) {
                                    return 'Sem dados';
                                }
                                return 'Score: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 40,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });

        // Question Charts - Dynamic charts for each daily report question
        const questionChartsData = @json($questionCharts);
        const chartLabelsData = @json($chartLabels);
        
        const chartColors = [
            { border: 'rgb(59, 130, 246)', bg: 'rgba(59, 130, 246, 0.1)' },      // Blue
            { border: 'rgb(168, 85, 247)', bg: 'rgba(168, 85, 247, 0.1)' },    // Purple
            { border: 'rgb(34, 197, 94)', bg: 'rgba(34, 197, 94, 0.1)' },      // Green
            { border: 'rgb(239, 68, 68)', bg: 'rgba(239, 68, 68, 0.1)' },      // Red
        ];
        
        questionChartsData.forEach((questionChart, index) => {
            const chartId = 'questionChart' + questionChart.id;
            const chartElement = document.getElementById(chartId);
            
            if (chartElement) {
                const color = chartColors[index % chartColors.length];
                
                new Chart(chartElement, {
                    type: 'line',
                    data: {
                        labels: chartLabelsData,
                        datasets: [{
                            label: questionChart.name,
                            data: questionChart.data,
                            borderColor: color.border,
                            backgroundColor: color.bg,
                            tension: 0.4,
                            fill: true,
                            spanGaps: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        if (context.parsed.y === null) {
                                            return 'Sem dados';
                                        }
                                        return 'Valor: ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 10,
                                ticks: {
                                    stepSize: 2
                                }
                            }
                        }
                    }
                });
            }
        });
    });
</script>
@endpush
