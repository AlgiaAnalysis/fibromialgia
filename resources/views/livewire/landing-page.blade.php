<div class="flex items-center justify-center h-screen">
    <!-- Modal de Logs de Ações -->
    <x-ts-modal
        title="Modal de Teste"
        wire="modal"
        center
        size="4xl"
    >
        <div class="p-6">
            <h1>Modal de Teste</h1>
        </div>

        <x-slot:footer>
            <div class="w-full flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <button
                        wire:click="hideModal"
                        class="flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 hover:cursor-pointer transition-colors duration-200"
                    >
                        <i class="fad fa-times mr-2"></i>
                        Fechar
                    </button>
                </div>
            </div>
        </x-slot:footer>
    </x-ts-modal> 

    <button type="button" wire:loading.attr="disabled" wire:click="showModal" class="px-6 py-2.5 bg-gray-800 text-white hover:cursor-pointer hover:bg-gray-700 font-semibold transition-colors duration-200 rounded-md border border-gray-800 disabled:opacity-50 text-base md:text-lg flex items-center justify-center">
        <i wire:loading.remove class="fad fa-user-plus mr-2"></i>
        <i wire:loading class="fad fa-spinner-third fa-spin mr-2"></i>
        <span wire:loading.remove>Mostrar Modal</span>
        <span wire:loading>Mostrando...</span>
    </button>
</div>
