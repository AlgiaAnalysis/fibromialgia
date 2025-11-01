<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/font-awesome-pro-master.min.css') }}?v=0.0.1">

        <tallstackui:script />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <x-ts-dialog />
            <x-ts-toast />

            <!-- Header -->
            <div class="bg-blue-300/60 backdrop-blur-sm shadow-lg rounded-b-4xl h-30">
                <div class="flex flex-row items-center justify-center px-6 py-8 space-x-12">
                    <!-- Logo and Title -->
                    <div class="flex items-center justify-center mr-6">
                        <div class="flex items-center justify-center w-14 h-14 bg-blue-500/80 rounded-lg shadow-md">
                            <i class="fad fa-star-of-life text-white text-2xl"></i>
                        </div>
                        <div class="flex flex-col pl-4">
                            <h1 class="text-2xl font-bold text-blue-500/80">AlgiaAnalysis</h1>
                            <p class="text-sm text-gray-800/50">Sistema de Gestão de Pacientes</p>
                        </div>
                    </div>

                    <!-- Navigation - Centralizado -->
                    <div class="flex items-center justify-center">
                        <nav class="flex items-center space-x-2" aria-label="Navegação principal">
                            <a href="#" class="flex items-center text-blue-500/80 hover:text-white text-lg transition-colors px-4 py-3 rounded-lg hover:bg-blue-600/50 whitespace-nowrap">
                                <i class="fad fa-home mr-2"></i>
                                <span>Início</span>
                            </a>
                            <a href="#" class="flex items-center text-blue-500/80 hover:text-white text-lg transition-colors px-4 py-3 rounded-lg hover:bg-blue-600/50 whitespace-nowrap">
                                <i class="fad fa-users mr-2"></i>
                                <span>Pacientes</span>
                            </a>
                            <a href="#" class="flex items-center text-blue-500/80 hover:text-white text-lg transition-colors px-4 py-3 rounded-lg hover:bg-blue-600/50 whitespace-nowrap">
                                <i class="fad fa-user-md mr-2"></i>
                                <span>Médicos</span>
                            </a>
                            <a href="#" class="flex items-center text-blue-500/80 hover:text-white text-lg transition-colors px-4 py-3 rounded-lg hover:bg-blue-600/50 whitespace-nowrap">
                                <i class="fad fa-clipboard-list mr-2"></i>
                                <span>Questionários</span>
                            </a>
                            <a href="#" class="flex items-center text-blue-500/80 hover:text-white text-lg transition-colors px-4 py-3 rounded-lg hover:bg-blue-600/50 whitespace-nowrap">
                                <i class="fad fa-chart-line mr-2"></i>
                                <span>Análises</span>
                            </a>
                        </nav>
                    </div>

                    <!-- User Menu - Direita -->
                    <div x-data="{ isMenuOpen: false }"
                        class="flex items-center justify-center space-x-2">
                        <!-- User Dropdown -->
                        <div @click="isMenuOpen = !isMenuOpen" class="flex items-center space-x-2 bg-blue-500/80 rounded-lg px-4 py-3 cursor-pointer transition-colors shadow-md">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                <i class="fad fa-user text-blue-500/80 text-lg"></i>
                            </div>
                            <span class="text-white font-medium hidden md:block">Admin</span>
                            <i class="fad fa-chevron-down text-white text-xs"></i>
                        </div>

                        <!-- Dropdown menu -->
                        <div x-show="isMenuOpen"
                            @click.outside="isMenuOpen = false"
                            x-transition
                            x-cloak
                            class="absolute right-98 mt-78 w-64 bg-white rounded-lg shadow-lg z-50 border border-gray-200">
                            <!-- Admin menu -->
                            <div class="px-4 py-3 border-b mt-0 border-gray-100 bg-blue-500/80 rounded-t-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-white text-blue-500/80 rounded-lg flex items-center justify-center font-semibold text-lg">
                                        <i class="fad fa-user text-blue-500/80 text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-white truncate">nome@email.com</p>
                                        <p class="text-xs text-gray-800/50 capitalize">Administrador</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="py-2">
                                <button class="w-full px-4 py-2 text-left hover:cursor-pointer hover:bg-blue-200/50 text-sm text-gray-700 flex items-center">
                                    <i class="fad fa-user-shield text-blue-500 mr-3"></i>
                                    Configurações
                                </button>
                                <button class="w-full px-4 py-2 text-left hover:cursor-pointer hover:bg-blue-200/50 text-sm text-gray-700 flex items-center">
                                    <i class="fad fa-key text-green-500 mr-3"></i>
                                    Alterar Senha
                                </button>
                            </div>
                            
                            <div class="border-t border-gray-100 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full hover:cursor-pointer px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 flex items-center">
                                        <i class="fad fa-sign-out text-red-500 mr-3"></i>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="h-[calc(100vh-140px)] overflow-y-auto">
                <div class="container mx-auto px-50 py-2">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScripts
    </body>
</html>
