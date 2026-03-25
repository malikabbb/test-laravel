<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Application</title>
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
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
            </div>
            <h2 class="text-5xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">Welcome Back<br><span class="text-orange-500">to your Workspace</span></h2>
            <p class="text-xl text-slate-600 leading-relaxed max-w-lg">Sign in to securely access your dashboard, manage your operations, and stay productive everywhere you go.</p>
        </div>

        <!-- Right Side: Form Container (Always Visible) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 sm:p-8 lg:p-12">
            
            <!-- Glassmorphism Form Card -->
            <div class="w-full max-w-[440px] bg-white/70 backdrop-blur-xl p-8 sm:p-10 rounded-3xl shadow-2xl shadow-slate-200/50 border border-white">
                
                <!-- Mobile Logo (Hidden on desktop) -->
                <div class="lg:hidden flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-tr from-orange-500 to-orange-400 rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                    </div>
                </div>

                <div class="text-center mb-10">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Sign In</h1>
                    <p class="text-slate-500 mt-2 font-medium">Access your account dashboard</p>
                </div>

                @if(session('error'))
                    <div class="mb-6 p-4 text-sm font-medium text-red-700 bg-red-100/80 backdrop-blur-md rounded-2xl border border-red-200 flex items-center shadow-sm" role="alert">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-6 p-4 text-sm font-medium text-green-700 bg-green-100/80 backdrop-blur-md rounded-2xl border border-green-200 flex items-center shadow-sm" role="alert">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="block w-full px-5 py-3.5 rounded-xl border @error('email') border-red-500 bg-red-50 focus:ring-red-500 @else border-slate-200 bg-white/60 focus:bg-white focus:ring-orange-500 @enderror focus:ring-2 focus:border-transparent transition-all duration-300 outline-none placeholder-slate-400 font-medium shadow-sm" placeholder="name@company.com">
                        @error('email') 
                            <p class="mt-2 text-sm font-semibold text-red-500 flex items-start">
                                <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                            <a href="#" class="text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors">Forgot password?</a>
                        </div>
                        <input type="password" id="password" name="password" class="block w-full px-5 py-3.5 rounded-xl border @error('password') border-red-500 bg-red-50 focus:ring-red-500 @else border-slate-200 bg-white/60 focus:bg-white focus:ring-orange-500 @enderror focus:ring-2 focus:border-transparent transition-all duration-300 outline-none placeholder-slate-400 font-medium shadow-sm" placeholder="••••••••">
                        @error('password') 
                            <p class="mt-2 text-sm font-semibold text-red-500 flex items-start">
                                <svg class="w-4 h-4 mr-1.5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                <span>{{ $message }}</span>
                            </p> 
                        @enderror
                    </div>

                    <div class="flex items-center pt-2">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-orange-500 focus:ring-orange-500 border-slate-300 rounded cursor-pointer accent-orange-500 shadow-sm transition-all duration-200">
                        <label for="remember" class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button type="submit" class="w-full relative mt-4 h-14 flex items-center justify-center bg-gradient-to-r from-orange-500 to-orange-400 hover:from-orange-600 hover:to-orange-500 active:scale-[0.98] text-white font-bold px-4 rounded-xl shadow-lg shadow-orange-500/30 transition-all duration-200 overflow-hidden group">
                        <span class="relative z-10 flex items-center">
                            Sign In to Account
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                    </button>
                    
                    <p class="mt-8 text-center text-sm font-medium text-slate-500">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-bold text-orange-500 hover:text-orange-600 transition-colors uppercase tracking-wide text-xs ml-1">Create an account</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
