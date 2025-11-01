<div class="py-8 pt-4 px-13">
    <div class="w-full">
        <div class="flex items-center mb-8">
            <div class="bg-blue-500/10 rounded-lg px-5 py-4 mr-3">
                <i class="fad fa-user-injured text-blue-500 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-blue-500/80">Vincular Pacientes</h3>
                <p class="text-sm text-gray-600">Busque e vincule pacientes ao seu perfil</p>
            </div>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Search Type Select -->
                <div class="flex-1">
                    <div class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fad fa-filter text-blue-500 mr-2"></i>Tipo de Busca
                    </div>
                    <select wire:model="searchType" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                        <option value="name">Nome</option>
                        <option value="cpf">CPF</option>
                    </select>
                </div>

                <!-- Search Input -->
                <div class="flex-1">
                    <div class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fad fa-search text-blue-500 mr-2"></i>Digite para buscar
                    </div>
                    <input
                        type="text"
                        wire:model="searchQuery"
                        wire:keydown.enter="searchPatients"
                        placeholder="{{ $searchType === 'name' ? 'Digite o nome do paciente' : 'Digite o CPF do paciente' }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200">
                </div>

                <!-- Search Button -->
                <div class="flex items-end">
                    <button
                        wire:click="searchPatients"
                        wire:loading.attr="disabled"
                        class="w-full md:w-auto px-8 py-3 hover:cursor-pointer bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-all duration-200 flex items-center justify-center disabled:opacity-50 shadow-md">
                        <i class="fad fa-search mr-2" wire:loading.remove wire:target="searchPatients"></i>
                        <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="searchPatients"></i>
                        <span wire:loading.remove wire:target="searchPatients">Buscar</span>
                        <span wire:loading wire:target="searchPatients">Buscando...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Results List -->
        @if($showResults && count($searchResults) > 0)
            <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                <div class="flex items-center mb-6">
                    <div class="bg-green-500/10 rounded-lg px-4 py-3 mr-3">
                        <i class="fad fa-list text-green-500 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Resultados da Busca</h3>
                        <p class="text-sm text-gray-500">{{ count($searchResults) }} paciente(s) encontrado(s)</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($searchResults as $result)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-center justify-between">
                                <!-- Patient Info -->
                                <div class="flex items-center flex-1">
                                    <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mr-4">
                                        <i class="fad fa-user-injured text-blue-500 text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $result['name'] }}</h4>
                                        <div class="flex items-center space-x-4 mt-1">
                                            <span class="text-sm text-gray-600">
                                                <i class="fad fa-id-card text-blue-500 mr-1"></i>{{ $result['cpf'] }}
                                            </span>
                                            <span class="text-sm text-gray-600">
                                                <i class="fad fa-envelope text-blue-500 mr-1"></i>{{ $result['email'] }}
                                            </span>
                                            <span class="text-sm {{ $result['score'] > 0 ? 'text-green-600' : 'text-gray-400' }}">
                                                <i class="fad fa-chart-line mr-1"></i>Score: {{ $result['score'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="ml-4">
                                    @if($result['is_linked'])
                                        <button disabled class="px-6 py-3 bg-gray-300 text-gray-600 font-semibold rounded-lg cursor-not-allowed flex items-center shadow-md">
                                            <i class="fad fa-check-circle mr-2"></i>
                                            Vinculado
                                        </button>
                                    @else
                                        <button
                                            wire:click="dialogLinkPatient({{ $result['patient_id'] }})"
                                            wire:loading.attr="disabled"
                                            class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-all duration-200 flex items-center disabled:opacity-50 shadow-md">
                                            <i class="fad fa-link mr-2" wire:loading.remove wire:target="dialogLinkPatient({{ $result['patient_id'] }})"></i>
                                            <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="dialogLinkPatient({{ $result['patient_id'] }})"></i>
                                            <span wire:loading.remove wire:target="dialogLinkPatient({{ $result['patient_id'] }})">Vincular</span>
                                            <span wire:loading wire:target="dialogLinkPatient({{ $result['patient_id'] }})">Vinculando...</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif($showResults && count($searchResults) === 0)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mb-4">
                        <i class="fad fa-search text-blue-500 text-3xl"></i>
                    </div>
                    <p class="text-sm text-blue-700 font-medium">
                        Nenhum paciente encontrado com o termo "{{ $searchQuery }}"
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
