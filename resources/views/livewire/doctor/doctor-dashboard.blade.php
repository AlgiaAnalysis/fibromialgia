<div class="py-8 pt-4">
    <div class="w-full">
        <!-- Top row with 3 equal-sized cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 mt-6">
            <!-- Quick Access Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <!-- Black header -->
                <div class="bg-blue-300/60 h-30 py-8 pt-5 rounded-b-lg px-6 relative">
                    <div class="flex items-center">
                        <h3 class="text-lg font-semibold text-blue-500/80">Acesso Rápido</h3>
                    </div>
                    
                    <!-- Newsletters button - overlapping -->
                    <div class="absolute left-4 right-4 -bottom-12">
                        <div class="grid grid-cols-2 gap-4">
                            <button wire:click="showAllEditions" class="block w-full">
                                <div class="bg-blue-400 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    <div class="p-4 text-center">
                                        <div class="flex flex-col items-center space-y-2">
                                            <i wire:loading.remove wire:target="showAllEditions"
                                                class="fad fa-clipboard-list text-2xl text-white"></i>
                                            <i wire:loading wire:target="showAllEditions"
                                                class="fad fa-spinner fa-spin text-2xl text-white"></i>
                                            <span class="text-white font-medium">Questionários</span>
                                        </div>
                                    </div>
                                </div>
                            </button>

                            <button wire:click="showAllEditions" class="block w-full">
                                <div class="bg-blue-400 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                    <div class="p-4 text-center">
                                        <div class="flex flex-col items-center space-y-2">
                                            <i wire:loading.remove wire:target="showAllEditions"
                                                class="fad fa-chart-line text-2xl text-white"></i>
                                            <i wire:loading wire:target="showAllEditions"
                                                class="fad fa-spinner fa-spin text-2xl text-white"></i>
                                            <span class="text-white font-medium">Análises</span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Quick access buttons -->
                <div class="p-4 pt-16 space-y-4">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Authors button -->
                        <button wire:click="showAllEditions" class="block w-full">
                            <div class="bg-blue-400 rounded-lg shadow-md border hover:cursor-pointer border-gray-200 overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="p-4 text-center">
                                    <div class="flex flex-col items-center space-y-2">
                                        <i wire:loading.remove wire:target="showAllEditions"
                                            class="fad fa-user-injured text-2xl text-white"></i>
                                        <i wire:loading wire:target="showAllEditions"
                                            class="fad fa-spinner fa-spin text-2xl text-white"></i>
                                        <span class="text-white font-medium">Pacientes</span>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
    
            <!-- Schedule Emails Stats Card Component -->
            <div class="col-span-2">
                <!-- Schedule Emails Stats Card -->
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-500/80 rounded-lg px-4 py-3 mr-4">
                                    <i class="fad fa-database text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Estatísticas Gerais</h3>
                                    <p class="text-sm text-gray-500">
                                        Acompanhe as estatísticas gerais do sistema
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <!-- Total -->
                        <div class="flex items-center p-4 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-200">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                                <i class="fad fa-user-injured text-2xl text-gray-800"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Pacientes</h4>
                                <span class="text-xl font-bold text-gray-800">{{ $doctorPatientsCount }}</span>
                            </div>
                        </div>

                        <!-- Sent -->
                        <div class="flex items-center p-4 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-lg transition-shadow duration-200">
                            <div class="w-12 h-12 rounded-lg bg-purple-100 border border-purple-200 flex items-center justify-center">
                                <i class="fad fa-clipboard-list text-2xl text-purple-600"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-500">Questionários</h4>
                                <span class="text-xl font-bold text-gray-800">{{ $questionnairesCount }}</span>
                            </div>
                        </div>
                    </div>

                    @if($doctorPatientsCount == 0)
                        <div class="bg-yellow-50 border border-yellow-200 mt-4 rounded-lg p-5">
                            <div class="flex flex-row justify-between items-center">
                                <div class="flex flex-row items-start">
                                    <i class="fad fa-exclamation-triangle text-yellow-500 text-2xl mr-4"></i>
                                    <span class="text-sm text-yellow-500"><strong>Atenção:</strong> Você ainda não possui pacientes cadastrados.</span>
                                </div>

                                <button
                                    wire:click="goToLinkPatient"
                                    class="bg-yellow-500 hover:cursor-pointer text-white px-4 py-2 rounded-lg">
                                    <i 
                                        wire:loading.remove
                                        wire:target="goToLinkPatient"
                                        class="fad fa-link text-white text-xl mr-2"></i>
                                    <i
                                        wire:loading
                                        wire:target="goToLinkPatient"
                                        class="fad fa-spinner fa-spin text-white text-xl mr-2"></i>
                                    <span wire:loading.remove wire:target="goToLinkPatient" class="text-white">Vincular Paciente</span>
                                    <span wire:loading wire:target="goToLinkPatient" class="text-white">Processando...</span>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border border-green-200 mt-4 rounded-lg p-5">
                            <div class="flex flex-row justify-between items-center">
                                <div class="flex flex-row items-start">
                                    <i class="fad fa-check-circle text-green-500 text-2xl mr-4"></i>
                                    <span class="text-sm text-green-500"><strong>Sucesso:</strong> Você possui {{ $doctorPatientsCount }} pacientes cadastrados.</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center my-8">
        <div class="flex-grow h-px bg-orange-300"></div>
            <div class="mx-6">
                <i class="fad fa-heartbeat text-orange-400 text-2xl"></i>
            </div>
        <div class="flex-grow h-px bg-orange-300"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Newsletters List Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-blue-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-chart-bar text-blue-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Análises Gerais</h3>
                        <p class="text-sm text-gray-500">
                            Veja as análises gerais do sistema
                        </p>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Newsletter Editions Card -->
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-orange-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-exclamation-circle text-orange-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Pacientes Críticos</h3>
                        <p class="text-sm text-gray-500">
                            Veja os pacientes críticos do sistema
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-6">
                <div class="flex flex-row justify-between bg-white rounded-lg shadow-md w-full p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-orange-500/10 border border-orange-200 flex items-center justify-center">
                            <i class="fad fa-user-injured text-2xl text-orange-500"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-500">João da Silva</h4>
                            <span class="text-lg font-bold text-orange-500">Score: 6.8</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row justify-between bg-white rounded-lg shadow-md w-full p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-orange-500/10 border border-orange-200 flex items-center justify-center">
                            <i class="fad fa-user-injured text-2xl text-orange-500"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-500">João da Silva</h4>
                            <span class="text-lg font-bold text-orange-500">Score: 6.8</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row justify-between bg-white rounded-lg shadow-md w-full p-6 border border-gray-200">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-lg bg-orange-500/10 border border-orange-200 flex items-center justify-center">
                            <i class="fad fa-user-injured text-2xl text-orange-500"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-500">João da Silva</h4>
                            <span class="text-lg font-bold text-orange-500">Score: 6.8</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
