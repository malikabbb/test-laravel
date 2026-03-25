<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Gym Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        #mobile-menu:checked ~ #sidebar { transform: translateX(0); }
        #mobile-menu:checked ~ #overlay { display: block; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-hidden flex h-screen">

    <input type="checkbox" id="mobile-menu" class="hidden">
    <label for="mobile-menu" id="overlay" class="fixed inset-0 bg-slate-900/50 z-20 hidden lg:hidden cursor-pointer backdrop-blur-sm transition-opacity"></label>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white/90 backdrop-blur-xl border-r border-slate-200 transform -translate-x-full lg:translate-x-0 lg:static lg:flex flex-col transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-slate-100 bg-white/50">
            <div class="w-8 h-8 bg-gradient-to-tr from-orange-500 to-orange-400 rounded-lg flex items-center justify-center mr-3 shadow-md shadow-orange-500/30">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <span class="font-extrabold text-xl text-slate-900 tracking-tight">FitPro</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-orange-50 text-orange-600 shadow-sm border border-orange-100/50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} flex items-center px-3 py-2.5 font-semibold rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-orange-500' : 'text-slate-400 group-hover:text-orange-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Overview
            </a>
            <a href="{{ route('members.index') }}" class="{{ request()->routeIs('members.*') ? 'bg-orange-50 text-orange-600 shadow-sm border border-orange-100/50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} flex items-center px-3 py-2.5 font-semibold rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('members.*') ? 'text-orange-500' : 'text-slate-400 group-hover:text-orange-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Members
            </a>
            <a href="{{ route('trainers.index') }}" class="{{ request()->routeIs('trainers.*') ? 'bg-orange-50 text-orange-600 shadow-sm border border-orange-100/50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} flex items-center px-3 py-2.5 font-semibold rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('trainers.*') ? 'text-orange-500' : 'text-slate-400 group-hover:text-orange-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Trainers
            </a>
                <a href="{{ route('classes.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all {{ request()->routeIs('classes.*') ? 'bg-orange-50 text-orange-600 font-bold shadow-sm border border-orange-100' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 font-medium' }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs('classes.*') ? 'text-orange-500' : 'text-slate-400 group-hover:text-slate-600' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Classes
                </a>
            <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'bg-orange-50 text-orange-600 shadow-sm border border-orange-100/50' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }} flex items-center px-3 py-2.5 font-semibold rounded-xl transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 {{ request()->routeIs('payments.*') ? 'text-orange-500' : 'text-slate-400 group-hover:text-orange-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Payments
            </a>
        </nav>

        <!-- User/Logout -->
        <div class="p-4 border-t border-slate-100 bg-slate-50/50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2.5 text-slate-500 hover:text-red-600 hover:bg-red-50 font-semibold rounded-xl transition-colors group">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 group-hover:block transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col min-w-0 bg-slate-50/50">
        <!-- Topbar -->
        <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200/50 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10 sticky top-0 shadow-sm">
            <div class="flex items-center">
                <!-- Mobile Menu Button -->
                <label for="mobile-menu" class="lg:hidden text-slate-500 hover:text-orange-500 cursor-pointer mr-4 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </label>
                
                <!-- Search -->
                <form action="{{ route('search') }}" method="GET" class="hidden sm:block relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400 group-focus-within:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="q" value="{{ request('q') }}" class="block w-full pl-10 pr-3 py-2 bg-slate-100/50 border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 focus:bg-white transition-all w-64 md:w-80 font-medium" placeholder="Search members, trainers, classes...">
                </form>
            </div>

            <!-- Profile Widget -->
            <div class="flex items-center space-x-5">
                <div class="flex items-center pl-4 border-l border-slate-200">
                    <img class="h-9 w-9 rounded-full shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=f97316&color=fff&bold=true" alt="Avatar">
                    <div class="ml-3 hidden md:block">
                        <p class="text-sm font-bold text-slate-700 leading-tight">{{ auth()->user()->name ?? 'System Admin' }}</p>
                        <p class="text-xs font-medium text-slate-500">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Page Content -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">@yield('header_title', 'Dashboard Overview')</h1>
                    <p class="text-slate-500 mt-1 font-medium">@yield('header_subtitle', 'Here is what is happening at your gym today.')</p>
                </div>
                @yield('header_actions')
            </div>

            @yield('content')

            <footer class="mt-12 text-center text-sm font-medium text-slate-400 bg-white/50 py-4 rounded-xl border border-slate-100">
                &copy; {{ date('Y') }} FitPro System. Built with perfection.
            </footer>
        </div>
    </main>
</body>
</html>
