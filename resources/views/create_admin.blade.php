<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin | Setup System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased min-h-screen relative overflow-x-hidden">
    
    <!-- Shared Ambient Background (Visible on ALL devices) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50vh] h-[50vh] bg-orange-200/50 rounded-full mix-blend-multiply filter blur-[80px] animate-blob"></div>
        <div class="absolute top-[20%] right-[-10%] w-[50vh] h-[50vh] bg-rose-200/40 rounded-full mix-blend-multiply filter blur-[80px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-[-10%] left-[20%] w-[60vh] h-[60vh] bg-amber-200/50 rounded-full mix-blend-multiply filter blur-[80px] animate-blob animation-delay-4000"></div>
    </div>

    <!-- Layout Container -->
    <div class="relative z-10 flex min-h-screen w-full">
        
        <!-- Left Side: Hero Text (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-center px-16 xl:px-24">
            <div class="w-20 h-20 bg-gradient-to-tr from-orange-500 to-orange-400 rounded-2xl mb-8 shadow-xl shadow-orange-500/30 flex items-center justify-center transform hover:scale-105 transition-transform duration-300">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <h2 class="text-5xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">System<br><span class="text-orange-500">Initialization</span></h2>
            <p class="text-xl text-slate-600 leading-relaxed max-w-lg">Create the primary administrator account to secure and manage your new platform dynamically.</p>
        </div>

        <!-- Right Side: Form Container (Always Visible) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 lg:p-12 overflow-y-auto">
            
            <!-- Glassmorphism Form Card -->
            <div class="w-full max-w-[440px] bg-white/70 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-2xl shadow-slate-200/50 border border-white">
                
                <!-- Mobile Logo (Hidden on desktop) -->
                <div class="lg:hidden flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-tr from-orange-500 to-orange-400 rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0..."></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                </div>

                <div class="text-center mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Setup Admin</h1>
                    <p class="text-slate-500 mt-2 font-medium">Initialize system access control</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 text-sm font-medium text-red-700 bg-red-100/80 backdrop-blur-md rounded-2xl border border-red-200 flex items-center shadow-sm" role="alert">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.create') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="block w-full px-5 py-3 rounded-xl border @error('name') border-red-500 bg-red-50 focus:ring-red-500 @else border-slate-200 bg-white/60 focus:bg-white focus:ring-orange-500 @enderror focus:ring-2 focus:border-transparent transition-all duration-300 outline-none placeholder-slate-400 font-medium shadow-sm" placeholder="e.g. System Admin">
                        @error('name') 
                            <p class="mt-2 text-sm font-semibold text-red-500 flex items-start">
                                <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="block w-full px-5 py-3 rounded-xl border @error('email') border-red-500 bg-red-50 focus:ring-red-500 @else border-slate-200 bg-white/60 focus:bg-white focus:ring-orange-500 @enderror focus:ring-2 focus:border-transparent transition-all duration-300 outline-none placeholder-slate-400 font-medium shadow-sm" placeholder="admin@domain.com">
                        @error('email') 
                            <p class="mt-2 text-sm font-semibold text-red-500 flex items-start">
                                <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                        <div class="bg-orange-50/50 rounded-lg p-2.5 mb-2 border border-orange-100">
                            <ul class="text-xs text-orange-800 ml-3 list-disc space-y-0.5 font-medium">
                                <li>At least 8 characters</li>
                                <li>Include uppercase & lowercase</li>
                                <li>Include numbers & symbols</li>
                            </ul>
                        </div>
                        <input type="password" id="password" name="password" class="block w-full px-5 py-3 rounded-xl border @error('password') border-red-500 bg-red-50 focus:ring-red-500 @else border-slate-200 bg-white/60 focus:bg-white focus:ring-orange-500 @enderror focus:ring-2 focus:border-transparent transition-all duration-300 outline-none placeholder-slate-400 font-medium shadow-sm" placeholder="••••••••">
                        @error('password') 
                            <p class="mt-2 text-sm font-semibold text-red-500 flex items-start">
                                <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="block w-full px-5 py-3 rounded-xl border border-slate-200 bg-white/60 focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-300 outline-none placeholder-slate-400 font-medium shadow-sm" placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full relative mt-4 h-14 flex items-center justify-center bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 active:scale-[0.98] text-white font-bold px-4 rounded-xl shadow-lg shadow-orange-500/30 transition-all duration-200 overflow-hidden group">
                        <span class="relative z-10 flex items-center">
                            Initialize System
                            <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </button>
                    
                    <div class="mt-6 text-center text-xs font-semibold text-slate-500 bg-white/60 p-3 rounded-xl border border-white backdrop-blur-sm">
                        <svg class="w-4 h-4 inline-block text-orange-500 mr-1 align-text-bottom" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        This page automatically locks after setup.
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
