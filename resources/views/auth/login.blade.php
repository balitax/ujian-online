@extends('layouts.auth')

@section('title', 'Login')

@section('styles')
<style>
    /* Mesh Gradient Background */
    .mesh-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background-color: oklch(var(--b1));
        background-image:
            radial-gradient(at 0% 0%, oklch(var(--p) / 0.15) 0, transparent 50%),
            radial-gradient(at 100% 100%, oklch(var(--s) / 0.15) 0, transparent 50%),
            radial-gradient(at 100% 0%, oklch(var(--a) / 0.1) 0, transparent 50%),
            radial-gradient(at 0% 100%, oklch(var(--wa) / 0.1) 0, transparent 50%);
    }

    /* Animated Blobs */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }

    /* Glass Card */
    .glass-card {
        background: oklch(var(--b1) / 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid oklch(var(--b3) / 0.3);
    }

    /* Feature pill */
    .feature-pill {
        background: oklch(var(--b1) / 0.8);
        backdrop-filter: blur(8px);
        border: 1px solid oklch(var(--b3) / 0.5);
        transition: all 0.3s ease;
    }
    .feature-pill:hover {
        background: oklch(var(--b1) / 0.95);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px oklch(var(--p) / 0.15);
    }

    /* Input focus glow */
    .input-glow:focus {
        box-shadow: 0 0 0 3px oklch(var(--p) / 0.2);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    {{-- Mesh Background --}}
    <div class="mesh-bg"></div>
    
    {{-- Animated Blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[120px] animate-blob"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary/10 rounded-full blur-[120px] animate-blob animation-delay-2000"></div>
        <div class="absolute top-[20%] right-[10%] w-[30%] h-[30%] bg-accent/10 rounded-full blur-[120px] animate-blob animation-delay-4000"></div>
    </div>

    {{-- Main Content --}}
    <div class="relative z-10 w-full max-w-5xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            
            {{-- Left Side - Branding & Features --}}
            <div class="hidden lg:block space-y-8">
                {{-- Logo --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-14 h-14 bg-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20">
                            <i class="fa-solid fa-graduation-cap text-2xl text-primary-content"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold tracking-tight">Ajenono</h1>
                            <p class="text-base-content/50 text-sm">Exam Platform</p>
                        </div>
                    </div>
                    <h2 class="text-4xl font-bold leading-tight mb-4">
                        Platform Ujian Online<br>
                        <span class="text-primary">Modern & Terpercaya</span>
                    </h2>
                    <p class="text-base-content/60 text-lg leading-relaxed">
                        Solusi lengkap untuk ujian online yang aman, cepat, dan mudah digunakan. 
                        Dirancang untuk sekolah dan institusi pendidikan.
                    </p>
                </div>

                {{-- Features Grid --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="feature-pill rounded-xl p-4 flex items-start gap-3">
                        <div class="w-9 h-9 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-shield-halved text-primary text-sm"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">Keamanan Tinggi</div>
                            <div class="text-xs text-base-content/50 mt-0.5">Anti-DDoS & CAPTCHA</div>
                        </div>
                    </div>
                    
                    <div class="feature-pill rounded-xl p-4 flex items-start gap-3">
                        <div class="w-9 h-9 bg-secondary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-bolt text-secondary text-sm"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">Autosave 15 Detik</div>
                            <div class="text-xs text-base-content/50 mt-0.5">Real-time sync</div>
                        </div>
                    </div>
                    
                    <div class="feature-pill rounded-xl p-4 flex items-start gap-3">
                        <div class="w-9 h-9 bg-accent/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-list-check text-accent text-sm"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">7 Tipe Soal</div>
                            <div class="text-xs text-base-content/50 mt-0.5">PG, Essay, Matching</div>
                        </div>
                    </div>
                    
                    <div class="feature-pill rounded-xl p-4 flex items-start gap-3">
                        <div class="w-9 h-9 bg-success/10 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-chart-line text-success text-sm"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm">Auto-Grading</div>
                            <div class="text-xs text-base-content/50 mt-0.5">Nilai otomatis</div>
                        </div>
                    </div>
                </div>

                {{-- Trust Badges --}}
                <div class="flex items-center gap-6 pt-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-primary">100%</div>
                        <div class="text-xs text-base-content/50">Open Source</div>
                    </div>
                    <div class="w-px h-10 bg-base-300"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-secondary">Free</div>
                        <div class="text-xs text-base-content/50">Selamanya</div>
                    </div>
                    <div class="w-px h-10 bg-base-300"></div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-accent">0</div>
                        <div class="text-xs text-base-content/50">CDN Dependencies</div>
                    </div>
                </div>
            </div>

            {{-- Right Side - Login Card --}}
            <div class="w-full max-w-md mx-auto lg:mx-0">
                {{-- Mobile Logo --}}
                <div class="lg:hidden text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl mb-4 shadow-lg shadow-primary/20">
                        <i class="fa-solid fa-graduation-cap text-3xl text-primary-content"></i>
                    </div>
                    <h1 class="text-2xl font-bold">Ajenono</h1>
                    <p class="text-base-content/50">Exam Platform</p>
                </div>

                {{-- Login Card --}}
                <div class="glass-card rounded-2xl p-8 shadow-xl">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold">Selamat Datang Kembali</h2>
                        <p class="text-base-content/50 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        {{-- Email --}}
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text font-medium text-sm">Email</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="input input-bordered w-full input-glow transition-all duration-200" 
                                placeholder="nama@sekolah.sch.id" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                            >
                        </div>
                        
                        {{-- Password --}}
                        <div class="form-control">
                            <label class="label pb-1">
                                <span class="label-text font-medium text-sm">Password</span>
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="input input-bordered w-full input-glow transition-all duration-200" 
                                placeholder="Masukkan password" 
                                required
                            >
                        </div>
                        
                        {{-- Remember & Forgot --}}
                        <div class="flex items-center justify-between">
                            <label class="label cursor-pointer gap-2 justify-start">
                                <input type="checkbox" id="remember" name="remember" class="checkbox checkbox-primary checkbox-sm" />
                                <span class="label-text text-sm">Ingat saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="link link-primary text-sm font-medium hover:opacity-80">Lupa password?</a>
                        </div>
                        
                        {{-- Turnstile CAPTCHA --}}
                        @if(config('services.turnstile.site_key'))
                            <div class="flex justify-center py-2">
                                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                            </div>
                            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                        @endif
                        
                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary w-full btn-lg shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 transition-all duration-200">
                            <i class="fa-solid fa-right-to-bracket"></i> Masuk
                        </button>
                    </form>
                    
                    {{-- Divider --}}
                    <div class="divider text-xs text-base-content/40 my-6">atau</div>
                    
                    {{-- Links --}}
                    <div class="space-y-2 text-center">
                        <p class="text-sm text-base-content/50">
                            Sekolah baru? 
                            <a href="{{ route('register.school') }}" class="link link-primary font-semibold">Daftarkan Sekolah</a>
                        </p>
                        <p class="text-sm text-base-content/50">
                            Tidak menerima email verifikasi? 
                            <a href="{{ route('verification.resend.show') }}" class="link link-primary">Kirim Ulang</a>
                        </p>
                    </div>
                </div>

                {{-- Footer --}}
                <p class="text-center text-xs text-base-content/40 mt-6">
                    &copy; {{ date('Y') }} Ajenono Exam Platform. Made with <i class="fa-solid fa-heart text-primary"></i> Open Source.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
