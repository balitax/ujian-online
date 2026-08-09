@extends('layouts.app')

@section('title', 'Login')

@section('styles')
<style>
    .login-hero {
        background: linear-gradient(135deg, oklch(var(--p)) 0%, oklch(var(--s)) 100%);
        position: relative;
        overflow: hidden;
    }
    .login-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .feature-card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }
    .feature-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    .floating-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
    }
</style>
@endsection

@section('content')
<div class="min-h-screen flex">
    {{-- Left Side - Hero & Features --}}
    <div class="hidden lg:flex lg:w-1/2 login-hero flex-col justify-between p-12 text-white relative">
        {{-- Floating shapes --}}
        <div class="floating-shape w-64 h-64 -top-32 -left-32"></div>
        <div class="floating-shape w-96 h-96 -bottom-48 -right-48"></div>
        <div class="floating-shape w-32 h-32 top-1/4 right-1/4"></div>
        
        {{-- Logo --}}
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Ajenono</h1>
                    <p class="text-white/70 text-sm">Exam Platform</p>
                </div>
            </div>
        </div>
        
        {{-- Features --}}
        <div class="relative z-10 space-y-4">
            <h2 class="text-3xl font-bold mb-6">Platform Ujian Online<br>Modern & Terpercaya</h2>
            
            <div class="feature-card rounded-xl p-4 flex items-start gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="font-semibold">Keamanan Tinggi</h3>
                    <p class="text-white/70 text-sm mt-1">Zero CDN dependencies, anti-DDoS, Cloudflare Turnstile CAPTCHA</p>
                </div>
            </div>
            
            <div class="feature-card rounded-xl p-4 flex items-start gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div>
                    <h3 class="font-semibold">Performa Tinggi</h3>
                    <p class="text-white/70 text-sm mt-1">Autosave setiap 15 detik, real-time countdown timer</p>
                </div>
            </div>
            
            <div class="feature-card rounded-xl p-4 flex items-start gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div>
                    <h3 class="font-semibold">7 Tipe Soal</h3>
                    <p class="text-white/70 text-sm mt-1">Pilihan ganda, essay, matching, sorting, dan lainnya</p>
                </div>
            </div>
            
            <div class="feature-card rounded-xl p-4 flex items-start gap-4">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
                <div>
                    <h3 class="font-semibold">Auto-Grading</h3>
                    <p class="text-white/70 text-sm mt-1">Penilaian otomatis dan laporan hasil ujian real-time</p>
                </div>
            </div>
        </div>
        
        {{-- Footer --}}
        <div class="relative z-10">
            <p class="text-white/50 text-sm">&copy; {{ date('Y') }} Ajenono Exam Platform. Open Source & Free.</p>
        </div>
    </div>
    
    {{-- Right Side - Login Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-base-100">
        <div class="w-full max-w-md">
            {{-- Mobile Logo --}}
            <div class="lg:hidden text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-2xl mb-4">
                    <i class="fa-solid fa-graduation-cap text-3xl text-primary"></i>
                </div>
                <h1 class="text-2xl font-bold">Ajenono</h1>
                <p class="text-base-content/60">Exam Platform</p>
            </div>
            
            {{-- Welcome Text --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold">Selamat Datang Kembali</h2>
                <p class="text-base-content/60 mt-2">Masuk ke akun Anda untuk melanjutkan</p>
            </div>
            
            {{-- Login Form --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                
                {{-- Email --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Email</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="input input-bordered w-full pl-11" 
                            placeholder="nama@sekolah.sch.id" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40"></i>
                    </div>
                </div>
                
                {{-- Password --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Password</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="input input-bordered w-full pl-11" 
                            placeholder="Masukkan password" 
                            required
                        >
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40"></i>
                    </div>
                </div>
                
                {{-- Remember & Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="label cursor-pointer gap-2">
                        <input type="checkbox" id="remember" name="remember" class="checkbox checkbox-sm checkbox-primary" />
                        <span class="label-text text-sm">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="link link-primary text-sm font-medium">Lupa password?</a>
                </div>
                
                {{-- Turnstile CAPTCHA --}}
                @if(config('services.turnstile.site_key'))
                    <div class="flex justify-center">
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                    </div>
                    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                @endif
                
                {{-- Submit --}}
                <button type="submit" class="btn btn-primary w-full btn-lg">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </button>
            </form>
            
            {{-- Divider --}}
            <div class="divider my-6">atau</div>
            
            {{-- Links --}}
            <div class="space-y-3 text-center">
                <p class="text-sm text-base-content/60">
                    Sekolah baru? 
                    <a href="{{ route('register.school') }}" class="link link-primary font-semibold">Daftarkan Sekolah Anda</a>
                </p>
                <p class="text-sm text-base-content/60">
                    Tidak menerima email verifikasi? 
                    <a href="{{ route('verification.resend.show') }}" class="link link-primary">Kirim Ulang</a>
                </p>
            </div>
            
            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-4 mt-10 p-4 bg-base-200 rounded-xl">
                <div class="text-center">
                    <div class="text-2xl font-bold text-primary">7</div>
                    <div class="text-xs text-base-content/60">Tipe Soal</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-secondary">100%</div>
                    <div class="text-xs text-base-content/60">Open Source</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent">Free</div>
                    <div class="text-xs text-base-content/60">Selamanya</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
