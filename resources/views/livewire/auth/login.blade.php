<div class="min-h-screen flex flex-col items-center justify-center relative py-6 px-4 sm:py-12 sm:px-6">
    <!-- Home button -->
    <a href="/" class="fixed top-4 right-4 px-4 py-3 bg-blue-300/60 shadow-xl border border-blue-200 rounded-lg text-blue-800 hover:bg-blue-800 hover:text-white font-semibold hover:cursor-pointer transition-colors duration-200 z-10">
        <i class="fad fa-star-of-life text-xl"></i>
    </a>

    <div class="bg-white rounded-lg shadow-xl border border-blue-200 w-full max-w-sm sm:max-w-md mx-auto">
        <div class="flex flex-row justify-between w-full mb-6 px-4">
            <div>
                <h2 class="text-2xl font-semibold text-left italic pt-8">AlgiaAnalysis</h2>
            </div>
        </div>
        
        <form wire:submit.prevent="handleSubmit" class="space-y-4 px-4">
            <!-- Email Field (sempre visível quando não está na verificação) -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    E-mail <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row">
                    <div class="p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-envelope text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="email"
                        type="email"
                        wire:model="email"
                        class="w-full px- pl-2 py-2 border border-gray-200 rounded-r-md focus:outline-none focus:ring-2 focus:ring-gray-800/40"
                        placeholder="seu@email.com"
                        required
                    />
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Senha <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row" x-data="{ showPassword: false }">
                    <div class="p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-key text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        wire:model="password"
                        class="w-full px-4 pl-2 py-2 border border-gray-200 focus:outline-none focus:ring-1 focus:ring-gray-800/40"
                        placeholder="Sua senha"
                        required
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="px-3 flex items-center bg-gray-200/50 rounded-r-md text-gray-500 hover:text-gray-700"
                    >
                        <i x-bind:class="showPassword ? 'fad fa-eye-slash' : 'fad fa-eye'" class="text-sm"></i>
                    </button>
                </div>
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="handleSubmit"
                class="w-full text-sm text-center hover:cursor-pointer bg-blue-800 text-white hover:bg-blue-700 font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <i class="fad fa-sign-in mr-2 text-xs" wire:loading.remove wire:target="handleSubmit"></i>
                <i class="fad fa-spinner-third fa-spin mr-2 text-xs" wire:loading wire:target="handleSubmit"></i>
                <span wire:loading.remove wire:target="handleSubmit">
                    Entrar
                </span>
                <span wire:loading wire:target="handleSubmit">Processando...</span>
            </button>
        </form>

        <div class="px-4 mt-6">
            @if($error)
                <div class="text-red-500 text-sm text-center">
                    {{ $error }}
                </div>
            @endif
            
            @if($success)
                <div class="text-green-500 text-sm text-center">
                    {{ $success }}
                </div>
            @endif
        </div>

        <div class="bg-blue-800 w-full h-1 mt-6 rounded-b-lg"></div>
    </div>

    <!-- Botões de Cadastro -->
    <div class="mt-6 w-full max-w-sm sm:max-w-md mx-auto">
        <div class="text-center mb-4">
            <p class="text-sm text-gray-600 mb-3">Ainda não tem uma conta?</p>
            <div class="flex flex-col gap-3">
                <!-- Botão Cadastro de Paciente -->
                <button wire:click="goToPatientSignUp"
                   class="flex-1 hover:cursor-pointer inline-flex items-center justify-center px-4 py-3 text-white hover:text-orange-400 bg-orange-400/60 border border-orange-300 hover:bg-orange-50 hover:border-orange-400 font-semibold rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                    <i
                        wire:loading.remove
                        wire:target="goToPatientSignUp"
                        class="fad fa-user-injured mr-2 text-sm"></i>
                    <i
                        wire:loading
                        wire:target="goToPatientSignUp"
                        class="fad fa-spinner fa-spin mr-2 text-sm"></i>
                    <span wire:loading.remove wire:target="goToPatientSignUp" class="text-sm">Cadastro de Paciente</span>
                    <span wire:loading wire:target="goToPatientSignUp" class="text-sm">Processando...</span>
                </button>
                
                <!-- Botão Cadastro de Médico -->
                <button wire:click="goToDoctorSignUp"
                   class="flex-1 hover:cursor-pointer inline-flex items-center justify-center px-4 py-3 text-white hover:text-blue-600 bg-blue-600/60 border border-blue-300 hover:bg-blue-50 hover:border-blue-400 font-semibold rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                    <i
                        wire:loading.remove
                        wire:target="goToDoctorSignUp"
                        class="fad fa-user-md mr-2 text-sm"></i>
                    <i
                        wire:loading
                        wire:target="goToDoctorSignUp"
                        class="fad fa-spinner fa-spin mr-2 text-sm"></i>
                    <span wire:loading.remove wire:target="goToDoctorSignUp" class="text-sm">Cadastro de Médico</span>
                    <span wire:loading wire:target="goToDoctorSignUp" class="text-sm">Processando...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
            © 2025 AlgiaAnalysis. Todos os direitos reservados.
        </p>
    </div>

    <style>
        [x-cloak] { 
            display: none !important; 
        }
    </style>
</div>
