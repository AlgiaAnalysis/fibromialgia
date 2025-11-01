<div class="min-h-screen flex flex-col items-center justify-center relative py-6 px-4 sm:py-12 sm:px-6">
    <!-- Floating buttons -->
    <div class="fixed top-4 right-4 flex flex-col gap-2 z-10">
        <!-- Home button -->
        <a href="/" class="p-3 bg-blue-300/60 shadow-xl border border-blue-200 rounded-lg text-blue-800 hover:bg-blue-800 hover:text-white font-semibold hover:cursor-pointer transition-colors duration-200">
            <i class="fad fa-home text-xl"></i>
        </a>
        
        <!-- Login button -->
        <a href="/login" class="p-3 bg-blue-300/60 shadow-xl border border-blue-200 rounded-lg text-blue-800 hover:bg-blue-800 hover:text-white font-semibold hover:cursor-pointer transition-colors duration-200">
            <i class="fad fa-sign-in text-xl"></i>
        </a>
    </div>

    <!-- Logo -->
    <div class="flex justify-center mb-4 sm:mb-6">
        <!-- <img src="{{ asset('images/spider_logo_transparent.png') }}" alt="WebNews" class="h-16 sm:h-20 w-auto" /> -->
    </div>

    <div class="bg-white rounded-lg shadow-xl border border-gray-200 w-full max-w-sm sm:max-w-md lg:max-w-lg mx-auto">
        <div class="flex flex-row justify-between w-full mb-4 sm:mb-6 px-4 sm:px-6">
            <div class="flex-1">
                <h2 class="text-xl sm:text-2xl font-semibold text-left italic pt-6 sm:pt-8">Cadastro de Doutor(a)</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Acompanhe os resultados dos questionários dos seus pacientes.
                </p>
                <p class="text-xs text-red-500 mt-2">
                    * Campos Obrigatórios
                </p>
            </div>
            <div class="hidden sm:flex justify-end">
                <!-- <img src="{{ asset('images/spider_going_down.png') }}" alt="Spider" class="w-16 h-16 object-contain" /> -->
            </div>
        </div>
        
        <form wire:submit.prevent="handleSubmit" class="space-y-4 px-4 sm:px-6">
            <!-- Nome Field (opcional) -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row">
                    <div class="p-2.5 sm:p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-user text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="name"
                        type="text"
                        wire:model="doctor.name"
                        class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-200 rounded-r-md focus:outline-none focus:ring-2 focus:ring-gray-800/40 text-sm sm:text-base"
                        placeholder="Seu nome completo"
                        required
                    />
                </div>
            </div>

            <!-- Email Field (obrigatório) -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    E-mail <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row">
                    <div class="p-2.5 sm:p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-envelope text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="email"
                        type="email"
                        wire:model="doctor.email"
                        class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-200 rounded-r-md focus:outline-none focus:ring-2 focus:ring-gray-800/40 text-sm sm:text-base"
                        placeholder="seu@email.com"
                        required
                    />
                </div>
            </div>

             <!-- Senha Field (obrigatório) -->
             <div class="mb-4" x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    CRM <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row relative">
                    <div class="p-2.5 sm:p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-user-md text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="crm"
                        wire:model="doctor.crm"
                        class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-200 rounded-r-md focus:outline-none focus:ring-2 focus:ring-gray-800/40 text-sm sm:text-base pr-10"
                        placeholder="CRM"
                        required
                    />
                </div>
            </div>

            <!-- Senha Field (obrigatório) -->
            <div class="mb-4" x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Senha <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row relative">
                    <div class="p-2.5 sm:p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-lock text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="password"
                        :type="show ? 'text' : 'password'"
                        wire:model="patient.password"
                        class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-200 rounded-r-md focus:outline-none focus:ring-2 focus:ring-gray-800/40 text-sm sm:text-base pr-10"
                        placeholder="Sua senha"
                        required
                    />
                    <button @click="show = !show" type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fad text-sm" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <!-- Confirmar Senha Field (obrigatório) -->
            <div class="mb-4" x-data="{ show: false }">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar Senha <span class="text-red-500">*</span>
                </label>
                <div class="flex flex-row relative">
                    <div class="p-2.5 sm:p-3 bg-gray-200/50 rounded-l-md flex items-center pointer-events-none">
                        <i class="fad fa-lock text-sm text-gray-600/70"></i>
                    </div>
                    <input
                        id="password_confirmation"
                        :type="show ? 'text' : 'password'"
                        wire:model="patient.passwordConfirmation"
                        class="w-full px-2 sm:px-3 py-2 sm:py-2.5 border border-gray-200 rounded-r-md focus:outline-none focus:ring-2 focus:ring-gray-800/40 text-sm sm:text-base pr-10"
                        placeholder="Confirme sua senha"
                        required
                    />
                    <button @click="show = !show" type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <i class="fad text-sm" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <!-- Botão Voltar para Login -->
                <button
                    wire:click="redirectToLogin"
                    wire:loading.attr="disabled"
                    wire:target="redirectToLogin"
                    type="button"
                    class="flex-1 text-sm text-center hover:cursor-pointer bg-white border border-gray-300 text-blue-800 hover:bg-blue-800 hover:text-white font-semibold py-2.5 sm:py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <i class="fad fa-arrow-left mr-2 text-xs" wire:loading.remove wire:target="redirectToLogin"></i>
                    <i class="fad fa-spinner-third fa-spin mr-2 text-xs" wire:loading wire:target="redirectToLogin"></i>
                    <span wire:loading.remove wire:target="redirectToLogin">Voltar</span>
                    <span wire:loading wire:target="redirectToLogin">Processando...</span>
                </button>

                <!-- Botão Principal (Cadastrar) -->
                <button
                    type="submit"
                    wire:loading.attr="disabled"
                    wire:target="handleSubmit"
                    class="flex-1 text-sm text-center hover:cursor-pointer bg-blue-800 text-white hover:bg-blue-700 font-semibold py-2.5 sm:py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <i class="fad fa-user-plus mr-2 text-xs" wire:loading.remove wire:target="handleSubmit"></i>
                    <i class="fad fa-spinner-third fa-spin mr-2 text-xs" wire:loading wire:target="handleSubmit"></i>
                    <span wire:loading.remove wire:target="handleSubmit">Cadastrar</span>
                    <span wire:loading wire:target="handleSubmit">Cadastrando...</span>
                </button>
            </div>
        </form>

        <div class="px-4 sm:px-6 mt-6">
            @if(!$error && !$success)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fad fa-info-circle text-blue-600 text-sm mt-0.5"></i>
                        </div>
                        <div class="ml-2">
                            <p class="text-xs sm:text-sm text-blue-800 font-medium">Como funciona?</p>
                            <p class="text-xs sm:text-sm text-blue-700 mt-1">
                                Após o cadastro, você será redirecionado para o sistema e poderá acompanhar os resultados dos questionários dos seus pacientes.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($error)
                <div class="text-red-500 text-sm text-center mb-4">
                    {{ $error }}
                </div>
            @endif
            
            @if($success)
                <div class="text-green-500 text-sm text-center mb-4">
                    {{ $success }}
                </div>
            @endif
        </div>

        <div class="bg-black w-full h-1 mt-6 rounded-b-lg"></div>
    </div>

    <!-- Footer -->
    <div class="mt-6 sm:mt-8 text-center px-4">
        <p class="text-xs text-gray-500">
            © 2025 WebNews. Todos os direitos reservados.
        </p>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
