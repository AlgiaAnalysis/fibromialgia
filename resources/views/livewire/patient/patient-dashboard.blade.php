<div class="py-8 pt-4">
    <div class="w-full">
        <div class="flex flex-row items-start justify-start">
            <div class="h-12 w-12 bg-bg-blue-500/80 rounded-lg flex items-center justify-center">
                <div class="flex flex-col items-center">
                    <i class="fad fa-user-injured text-2xl text-blue-500/80"></i>
                </div>
            </div>

            <div class="flex flex-col items-start justify-start">
                <h3 class="text-xl font-bold text-blue-500/80">Olá, Nome do Paciente!</h3>
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
                <div class="bg-orange-200/60 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-4 flex flex-row items-center justify-start">
                        <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <i wire:loading.remove wire:target="goToFiqrReportList"
                                    class="fad fa-clipboard-prescription text-2xl text-orange-500/80"></i>
                                <i wire:loading wire:target="goToFiqrReportList"
                                    class="fad fa-spinner fa-spin text-2xl text-orange-500/80"></i>
                            </div>
                        </div>

                        <div class="ml-4 flex flex-col items-start justify-start">
                            <span class="text-orange-500/80 font-medium">FIQR</span>
                            <span class="text-gray-500/80 font-medium text-xs">Quantidade de Envios: {{ $fiqrReportsCount }}</span>
                        </div>
                    </div>
                </div>
            </button>

            <button wire:click="goToAppointmentList" class="block w-full">
                <div class="bg-orange-200/60 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                    <div class="p-4 flex flex-row items-center justify-start">
                        <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center">
                            <div class="flex flex-col items-center">
                                <i wire:loading.remove wire:target="goToAppointmentList"
                                    class="fad fa-stethoscope text-2xl text-orange-500/80"></i>
                                <i wire:loading wire:target="goToAppointmentList"
                                    class="fad fa-spinner fa-spin text-2xl text-orange-500/80"></i>
                            </div>
                        </div>

                        <div class="ml-4 flex flex-col items-start justify-start">
                            <span class="text-orange-500/80 font-medium">Consultas</span>
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
                                    <h3 class="text-lg font-semibold text-gray-800">Score de Dor</h3>
                                    <p class="text-sm text-gray-500">Últimos 7 dias</p>
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
                            <svg class="transform -rotate-90 w-full h-full" viewBox="0 0 160 160">
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="10" fill="transparent" class="text-gray-200"></circle>
                                <circle cx="80" cy="80" r="70" stroke="currentColor" stroke-width="10" fill="transparent"
                                    stroke-dasharray="439.82"
                                    stroke-dashoffset="219.91"
                                    class="text-orange-500 transition-all duration-500"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-4xl font-bold text-gray-800">8</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <p class="text-lg font-semibold text-gray-800">Score de Hoje</p>
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

            <!-- Second Row: Two Line Charts -->
            <div class="grid grid-cols-2 gap-6">
                <!-- Sleep Quality Chart -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-moon text-blue-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Qualidade do Sono</h3>
                                    <p class="text-sm text-gray-500">Últimos 7 dias</p>
                                </div>
                            </div>
                        </div>
                        <div class="h-48 flex items-center justify-center">
                            <canvas id="sleepChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Fatigue Level Chart -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center">
                                <div class="bg-purple-500/10 rounded-lg px-4 py-3 mr-3">
                                    <i class="fad fa-tired text-purple-500 text-lg"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Nível de Fadiga</h3>
                                    <p class="text-sm text-gray-500">Últimos 7 dias</p>
                                </div>
                            </div>
                        </div>
                        <div class="h-48 flex items-center justify-center">
                            <canvas id="fatigueChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Pain Chart
        const painCtx = document.getElementById('painChart');
        new Chart(painCtx, {
            type: 'line',
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Nível de Dor',
                    data: [6, 5, 7, 4, 5, 6, 4],
                    borderColor: 'rgb(249, 115, 22)',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
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

        // Sleep Chart
        const sleepCtx = document.getElementById('sleepChart');
        new Chart(sleepCtx, {
            type: 'line',
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Qualidade do Sono',
                    data: [6, 7, 5, 8, 6, 7, 8],
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
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

        // Fatigue Chart
        const fatigueCtx = document.getElementById('fatigueChart');
        new Chart(fatigueCtx, {
            type: 'line',
            data: {
                labels: ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Nível de Fadiga',
                    data: [7, 6, 8, 5, 7, 6, 5],
                    borderColor: 'rgb(168, 85, 247)',
                    backgroundColor: 'rgba(168, 85, 247, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
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
    });
</script>
@endpush
