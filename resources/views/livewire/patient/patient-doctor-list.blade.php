<div class="py-8 pt-4">
    <div class="w-full">
        <div class="flex items-center mb-8">
            <div class="bg-blue-500/10 rounded-lg px-5 py-4 mr-3">
                <i class="fad fa-user-md text-blue-500 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-blue-500/80">Médicos Vinculados</h3>
                <p class="text-sm text-gray-600">Gerencie seus vínculos com médicos</p>
            </div>
        </div>

        <!-- Informative Alert -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <div class="shrink-0">
                    <i class="fad fa-info-circle text-blue-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800">
                        <strong>Informação Importante:</strong> Os médicos vinculados ao seu perfil têm acesso a todas as suas respostas de questionários (Diários, FIQR e Consultas) para auxiliar no acompanhamento da sua condição de saúde.
                    </p>
                </div>
            </div>
        </div>

        @if($doctorsList && count($doctorsList) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($doctorsList as $doctor)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
                        <div class="flex items-start justify-between">
                            <!-- Doctor Info -->
                            <div class="flex items-center flex-1">
                                <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mr-4">
                                    <i class="fad fa-user-md text-blue-500 text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $doctor['name'] }}</h4>
                                    <div class="flex items-center space-x-4 mt-1">
                                        <span class="text-sm text-gray-600">
                                            <i class="fad fa-id-badge text-blue-500 mr-1"></i>CRM: {{ $doctor['crm'] }}
                                        </span>
                                        <span class="text-sm text-gray-600">
                                            <i class="fad fa-envelope text-blue-500 mr-1"></i>{{ $doctor['email'] }}
                                        </span>
                                    </div>
                                    <!-- Status Badge -->
                                    <div class="mt-2">
                                        @if($doctor['status'] === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300">
                                                <i class="fad fa-clock mr-1"></i>Aguardando Aprovação
                                            </span>
                                        @elseif($doctor['status'] === 'linked')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-300">
                                                <i class="fad fa-check-circle mr-1"></i>Vinculado
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-6">
                            @if($doctor['status'] === 'pending')
                                <button
                                    wire:click="dialogApproveLink({{ $doctor['link_id'] }})"
                                    wire:loading.attr="disabled"
                                    class="w-full px-6 py-3 hover:cursor-pointer bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition-all duration-200 flex items-center justify-center disabled:opacity-50 shadow-md">
                                    <i class="fad fa-check-circle mr-2" wire:loading.remove wire:target="dialogApproveLink({{ $doctor['link_id'] }})"></i>
                                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="dialogApproveLink({{ $doctor['link_id'] }})"></i>
                                    <span wire:loading.remove wire:target="dialogApproveLink({{ $doctor['link_id'] }})">Aceitar Vínculo</span>
                                    <span wire:loading wire:target="dialogApproveLink({{ $doctor['link_id'] }})">Processando...</span>
                                </button>
                            @elseif($doctor['status'] === 'linked')
                                <button
                                    wire:click="dialogUnlinkDoctor({{ $doctor['link_id'] }})"
                                    wire:loading.attr="disabled"
                                    class="w-full px-6 py-3 hover:cursor-pointer bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-all duration-200 flex items-center justify-center disabled:opacity-50 shadow-md">
                                    <i class="fad fa-unlink mr-2" wire:loading.remove wire:target="dialogUnlinkDoctor({{ $doctor['link_id'] }})"></i>
                                    <i class="fad fa-spinner fa-spin mr-2" wire:loading wire:target="dialogUnlinkDoctor({{ $doctor['link_id'] }})"></i>
                                    <span wire:loading.remove wire:target="dialogUnlinkDoctor({{ $doctor['link_id'] }})">Remover Vínculo</span>
                                    <span wire:loading wire:target="dialogUnlinkDoctor({{ $doctor['link_id'] }})">Processando...</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-8">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mb-4">
                        <i class="fad fa-user-md text-blue-500 text-3xl"></i>
                    </div>
                    <p class="text-sm text-blue-700 font-medium">
                        Você ainda não possui médicos vinculados.
                    </p>
                    <p class="text-xs text-blue-600 mt-2">
                        Aguarde até que um médico solicite vinculação com você.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
