<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WASTE NO MORE') - NVAT Waste Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7c3aed',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="bg-gradient-to-b from-primary-600 to-secondary-600 w-64 min-h-screen p-4 text-white">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">WASTE NO MORE</h1>
                <p class="text-sm text-primary-100">NVAT Management System</p>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('ai-analytics.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('ai-analytics.*') ? 'bg-white/20' : '' }}">
                    <i class="fas fa-brain"></i>
                    <span>AI Analytics</span>
                </a>
                
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-primary-200 uppercase tracking-wider mb-3">Dashboard</h3>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-primary-200 uppercase tracking-wider mb-3">Data Entry</h3>
                    
                    <a href="{{ route('waste-entries.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('waste-entries.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-trash-alt"></i>
                        <span>Waste Entries</span>
                    </a>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-primary-200 uppercase tracking-wider mb-3">Processing Streams</h3>
                    
                    <a href="{{ route('anaerobic-digestion.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('anaerobic-digestion.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-biohazard"></i>
                        <span>Anaerobic Digestion</span>
                    </a>
                    
                    <a href="{{ route('bsf-larvae.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('bsf-larvae.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-bug"></i>
                        <span>BSF Larvae</span>
                    </a>
                    
                    <a href="{{ route('activated-carbon.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('activated-carbon.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-atom"></i>
                        <span>Activated Carbon</span>
                    </a>
                    
                    <a href="{{ route('paper-packaging.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('paper-packaging.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span>Paper & Packaging</span>
                    </a>
                    
                    <a href="{{ route('pyrolysis.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('pyrolysis.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-fire"></i>
                        <span>Pyrolysis</span>
                    </a>
                </div>
                
                <div class="mt-6">
                    <h3 class="text-sm font-semibold text-primary-200 uppercase tracking-wider mb-3">Management</h3>
                    
                    <a href="{{ route('inventory.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('inventory.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-boxes"></i>
                        <span>Inventory</span>
                    </a>
                    
                    <a href="{{ route('sales.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('sales.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Sales & Revenue</span>
                    </a>
                    
                    <a href="{{ route('energy.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('energy.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-bolt"></i>
                        <span>Energy Monitoring</span>
                    </a>
                    
                    <a href="{{ route('environmental-impact.index') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('environmental-impact.*') ? 'bg-white/20' : '' }}">
                        <i class="fas fa-leaf"></i>
                        <span>Environmental Impact</span>
                    </a>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-gray-600">@yield('page-description', 'Overview of waste management operations')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            {{ now()->format('M d, Y') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-2"></i>
                            {{ now()->format('h:i A') }}
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Please correct the following errors:</strong>
                        </div>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Menu Toggle (hidden on desktop) -->
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="mobile-menu-toggle" class="bg-primary-600 text-white p-2 rounded-lg shadow-lg">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    @stack('scripts')
    
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.bg-gradient-to-b');
            sidebar.classList.toggle('hidden');
        });
        
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
