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

    <body class="font-sans antialiased" x-data="{ activeTab: '{{ request()->route()->getName() }}', sidebarOpen: false }">
        <div class="min-h-screen bg-gray-50">
            <x-ts-dialog />
            <x-ts-toast />

            <!-- Header -->
            <div class="bg-blue-300/60 backdrop-blur-sm shadow-lg md:rounded-b-4xl md:h-30">
                <div class="container mx-auto px-4 md:px-50">
                    <div class="flex flex-row items-center justify-between py-4 md:py-8">
                        <!-- Logo and Title -->
                        <div class="flex items-center">
                            <div class="flex items-center justify-center w-12 h-12 md:w-14 md:h-14 bg-blue-500/80 rounded-lg shadow-md">
                                <i class="fad fa-star-of-life text-white text-xl md:text-2xl"></i>
                            </div>
                            <div class="flex flex-col pl-3 md:pl-4">
                                <h1 class="text-lg md:text-2xl font-bold text-blue-500/80">AlgiaAnalysis</h1>
                                <p class="text-xs md:text-sm text-gray-800/50">Sistema de Gestão de Pacientes</p>
                            </div>
                        </div>

                        <!-- Right Side: Mobile Hamburger / Desktop Sidebar Button -->
                        <div class="flex items-center">
                            <!-- Mobile: Hamburger Button -->
                            <button
                                @click="sidebarOpen = true"
                                class="md:hidden p-2 rounded-lg hover:bg-blue-400/50 transition-colors"
                                aria-label="Abrir menu de navegação">
                                <i class="fad fa-bars text-white text-2xl"></i>
                            </button>

                            <!-- Desktop: Sidebar Button -->
                            <button
                                @click="sidebarOpen = true"
                                class="hidden md:flex items-center space-x-2 bg-blue-500/80 rounded-lg px-4 py-3 cursor-pointer transition-colors shadow-md hover:bg-blue-600/80">
                                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                                    <i class="fad fa-user text-blue-500/80 text-lg"></i>
                                </div>
                                <span class="text-white font-medium">Doutor</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Overlay (Both Mobile and Desktop) - FORA do header! -->
            <div x-show="sidebarOpen"
                 @click="sidebarOpen = false"
                 x-cloak
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-transparent bg-opacity-50 z-40"></div>

            <!-- Mobile Sidebar (Right) - FORA do header! -->
            <div x-show="sidebarOpen"
                 @click.outside="sidebarOpen = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 x-cloak
                 class="fixed inset-y-0 right-0 z-50 w-64 bg-white shadow-xl md:hidden overflow-hidden">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 shrink-0">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 bg-blue-500/80 rounded-lg flex items-center justify-center shrink-0 mr-3">
                            <i class="fad fa-star-of-life text-white text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-gray-800 truncate">AlgiaAnalysis</h2>
                            <p class="text-xs text-gray-500 truncate">Menu de Navegação</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 text-gray-500 hover:text-gray-700 shrink-0">
                        <i class="fad fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Sidebar Content with proper scroll -->
                <div class="flex flex-col h-full overflow-y-auto pb-20">
                    <!-- Sidebar Navigation -->
                    <nav class="py-4 flex-1" aria-label="Navegação mobile">
                        <a href="{{ route('doctor.dashboard') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.dashboard' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-home text-gray-500 mr-3"></i>
                            <span class="font-medium">Início</span>
                        </a>
                        <a href="{{ route('doctor.link-patient') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.link-patient' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-users text-gray-500 mr-3"></i>
                            <span class="font-medium">Pacientes</span>
                        </a>
                        <a href="{{ route('doctor.reports-list') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.reports-list' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-clipboard-list text-gray-500 mr-3"></i>
                            <span class="font-medium">Questionários</span>
                        </a>
                        <a href="{{ route('doctor.report-analysis') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.report-analysis' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-chart-line text-gray-500 mr-3"></i>
                            <span class="font-medium">Análises</span>
                        </a>
                    </nav>

                    <!-- User section -->
                    <div class="border-t border-gray-200 shrink-0">
                        <div class="px-6 py-4 bg-gray-50">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-12 h-12 bg-blue-500/20 text-blue-500 rounded-lg flex items-center justify-center font-semibold text-lg shrink-0">
                                    <i class="fad fa-user text-blue-500 text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->usr_name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->usr_email }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <button class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                    <i class="fad fa-user-shield text-blue-500 mr-3"></i>
                                    Configurações
                                </button>
                                <button class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                    <i class="fad fa-key text-green-500 mr-3"></i>
                                    Alterar Senha
                                </button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-white rounded-lg transition-colors duration-200">
                                        <i class="fad fa-sign-out text-red-500 mr-3"></i>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Sidebar (Right) - FORA do header! -->
            <div x-show="sidebarOpen"
                 @click.outside="sidebarOpen = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 x-cloak
                 class="hidden md:block fixed top-0 right-0 h-screen w-80 max-w-[80vw] bg-white shadow-xl z-50 overflow-hidden">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 shrink-0">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 bg-blue-500/80 rounded-lg flex items-center justify-center shrink-0 mr-3">
                            <i class="fad fa-star-of-life text-white text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-lg font-bold text-gray-800 truncate">AlgiaAnalysis</h2>
                            <p class="text-xs text-gray-500 truncate">Menu de Navegação</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 text-gray-500 hover:text-gray-700 shrink-0">
                        <i class="fad fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Sidebar Content with proper scroll -->
                <div class="flex flex-col h-full overflow-y-auto pb-20">
                    <!-- Sidebar Navigation -->
                    <nav class="py-4 flex-1" aria-label="Navegação desktop">
                        <a href="{{ route('doctor.dashboard') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.dashboard' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-home text-gray-500 mr-3"></i>
                            <span class="font-medium">Início</span>
                        </a>
                        <a href="{{ route('doctor.link-patient') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.link-patient' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-users text-gray-500 mr-3"></i>
                            <span class="font-medium">Pacientes</span>
                        </a>
                        <a href="{{ route('doctor.reports-list') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.reports-list' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-clipboard-list text-gray-500 mr-3"></i>
                            <span class="font-medium">Questionários</span>
                        </a>
                        <a href="{{ route('doctor.report-analysis') }}"
                           @click="sidebarOpen = false"
                           :class="activeTab === 'doctor.report-analysis' ? 'bg-blue-50 border-l-4 border-blue-500' : ''"
                           class="flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                            <i class="fad fa-chart-line text-gray-500 mr-3"></i>
                            <span class="font-medium">Análises</span>
                        </a>
                    </nav>

                    <!-- User section -->
                    <div class="border-t border-gray-200 shrink-0">
                        <div class="px-6 py-4 bg-gray-50">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-12 h-12 bg-blue-500/20 text-blue-500 rounded-lg flex items-center justify-center font-semibold text-lg shrink-0">
                                    <i class="fad fa-user text-blue-500 text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->usr_name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->usr_email }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <button class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                    <i class="fad fa-user-shield text-blue-500 mr-3"></i>
                                    Configurações
                                </button>
                                <button class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-white rounded-lg transition-colors duration-200">
                                    <i class="fad fa-key text-green-500 mr-3"></i>
                                    Alterar Senha
                                </button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-white rounded-lg transition-colors duration-200">
                                        <i class="fad fa-sign-out text-red-500 mr-3"></i>
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="h-[calc(100vh-140px)] overflow-y-auto">
                <div class="container mx-auto px-4 md:px-50 py-2">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScripts
        @stack('scripts')
    </body>
</html>
