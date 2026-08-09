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

    /* Custom Input */
    .input-custom {
        height: 3rem;
        padding-left: 2.75rem;
        padding-right: 1rem;
        border-width: 1.5px;
        border-radius: 0.75rem;
        transition: all 0.2s ease;
        background: oklch(var(--b1));
    }
    .input-custom:focus {
        border-color: oklch(var(--p));
        box-shadow: 0 0 0 3px oklch(var(--p) / 0.15);
        outline: none;
    }
    .input-custom.input-error {
        border-color: oklch(var(--er));
        box-shadow: 0 0 0 3px oklch(var(--er) / 0.15);
    }
    .input-custom::placeholder {
        color: oklch(var(--bc) / 0.35);
    }

    /* Input wrapper */
    .input-wrapper {
        position: relative;
    }
    .input-wrapper .input-icon {
        position: absolute;
        left: 0.875rem;
        top: 50%;
        transform: translateY(-50%);
        color: oklch(var(--bc) / 0.35);
        transition: color 0.2s ease;
        pointer-events: none;
    }
    .input-wrapper:focus-within .input-icon {
        color: oklch(var(--p));
    }
    .input-wrapper .toggle-password {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: oklch(var(--bc) / 0.35);
        transition: color 0.2s ease;
        background: none;
        border: none;
        padding: 0.25rem;
    }
    .input-wrapper .toggle-password:hover {
        color: oklch(var(--bc) / 0.7);
    }

    /* Shake animation for errors */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
        20%, 40%, 60%, 80% { transform: translateX(4px); }
    }
    .shake {
        animation: shake 0.5s ease-in-out;
    }

    /* Toast animation */
    @keyframes toast-in {
        from { opacity: 0; transform: translateY(-16px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes toast-out {
        from { opacity: 1; transform: translateY(0) scale(1); }
        to { opacity: 0; transform: translateY(-16px) scale(0.95); }
    }
    .toast-animate-in {
        animation: toast-in 0.3s ease forwards;
    }
    .toast-animate-out {
        animation: toast-out 0.3s ease forwards;
    }

    /* Button loading state */
    .btn-loading {
        pointer-events: none;
        opacity: 0.8;
    }
    .btn-loading .btn-text {
        visibility: hidden;
    }
    .btn-loading::after {
        content: '';
        position: absolute;
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid transparent;
        border-top-color: currentColor;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
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

    {{-- Toast Container --}}
    <div id="toastContainer" class="fixed top-4 left-1/2 -translate-x-1/2 z-50 flex flex-col gap-2 items-center"></div>

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
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold">Selamat Datang Kembali</h2>
                        <p class="text-base-content/50 mt-1">Masuk ke akun Anda untuk melanjutkan</p>
                    </div>

                    <form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
                        @csrf
                        
                        {{-- Email --}}
                        <div class="form-control mb-5">
                            <label class="text-sm font-medium text-base-content/70 mb-2">
                                Email
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope input-icon text-sm"></i>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="input-custom w-full" 
                                    placeholder="nama@sekolah.sch.id" 
                                    value="{{ old('email') }}" 
                                    autofocus
                                >
                            </div>
                            <div id="emailError" class="text-xs text-error mt-1.5 hidden"></div>
                        </div>
                        
                        {{-- Password --}}
                        <div class="form-control mb-5">
                            <label class="text-sm font-medium text-base-content/70 mb-2">
                                Password
                            </label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock input-icon text-sm"></i>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="input-custom w-full pr-10" 
                                    placeholder="Masukkan password"
                                >
                                <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                                    <i class="fa-solid fa-eye text-sm" id="toggleIcon"></i>
                                </button>
                            </div>
                            <div id="passwordError" class="text-xs text-error mt-1.5 hidden"></div>
                        </div>
                        
                        {{-- Remember & Forgot --}}
                        <div class="flex items-center justify-between mb-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="remember" name="remember" class="checkbox checkbox-primary checkbox-sm rounded" />
                                <span class="text-sm text-base-content/60">Ingat saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-sm text-primary font-medium hover:underline">Lupa password?</a>
                        </div>
                        
                        {{-- Turnstile CAPTCHA --}}
                        @if(config('services.turnstile.site_key'))
                            <div class="flex justify-center mb-6">
                                <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                            </div>
                            <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                        @endif
                        
                        {{-- Submit --}}
                        <button type="submit" id="submitBtn" class="btn btn-primary w-full h-12 text-base shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 transition-all duration-200 rounded-xl relative">
                            <span class="btn-text flex items-center justify-center gap-2">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                <span>Masuk</span>
                            </span>
                        </button>
                    </form>
                    
                    {{-- Divider --}}
                    <div class="divider text-xs text-base-content/40 my-6">atau</div>
                    
                    {{-- Links --}}
                    <div class="space-y-3 text-center">
                        <p class="text-sm text-base-content/50">
                            Sekolah baru? 
                            <a href="{{ route('register.school') }}" class="text-primary font-semibold hover:underline">Daftarkan Sekolah</a>
                        </p>
                        <p class="text-sm text-base-content/50">
                            Tidak menerima email verifikasi? 
                            <a href="{{ route('verification.resend.show') }}" class="text-primary hover:underline">Kirim Ulang</a>
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

@section('scripts')
<script>
// Toast notification system
function showToast(message, type = 'error') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    
    const icons = {
        error: 'fa-circle-xmark',
        success: 'fa-circle-check',
        warning: 'fa-triangle-exclamation',
        info: 'fa-circle-info'
    };
    
    const colors = {
        error: 'bg-error text-error-content border-error',
        success: 'bg-success text-success-content border-success',
        warning: 'bg-warning text-warning-content border-warning',
        info: 'bg-info text-info-content border-info'
    };
    
    toast.className = `flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg border ${colors[type]} toast-animate-in max-w-sm`;
    toast.innerHTML = `
        <i class="fa-solid ${icons[type]}"></i>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    container.appendChild(toast);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.classList.remove('toast-animate-in');
        toast.classList.add('toast-animate-out');
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

// Toggle password visibility
function togglePasswordVisibility() {
    const input = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Validate form
function validateForm() {
    let isValid = true;
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    
    // Reset errors
    email.classList.remove('input-error', 'shake');
    password.classList.remove('input-error', 'shake');
    emailError.classList.add('hidden');
    passwordError.classList.add('hidden');
    
    // Validate email
    if (!email.value.trim()) {
        email.classList.add('input-error', 'shake');
        emailError.textContent = 'Email tidak boleh kosong';
        emailError.classList.remove('hidden');
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
        email.classList.add('input-error', 'shake');
        emailError.textContent = 'Format email tidak valid';
        emailError.classList.remove('hidden');
        isValid = false;
    }
    
    // Validate password
    if (!password.value.trim()) {
        password.classList.add('input-error', 'shake');
        passwordError.textContent = 'Password tidak boleh kosong';
        passwordError.classList.remove('hidden');
        isValid = false;
    } else if (password.value.length < 6) {
        password.classList.add('input-error', 'shake');
        passwordError.textContent = 'Password minimal 6 karakter';
        passwordError.classList.remove('hidden');
        isValid = false;
    }
    
    if (!isValid) {
        showToast('Mohon lengkapi form dengan benar', 'warning');
    }
    
    return isValid;
}

// Form submission
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateForm()) {
        return;
    }
    
    // Show loading state
    const btn = document.getElementById('submitBtn');
    btn.classList.add('btn-loading');
    
    // Submit form
    setTimeout(() => {
        this.submit();
    }, 300);
});

// Remove error state on input
document.getElementById('email').addEventListener('input', function() {
    this.classList.remove('input-error', 'shake');
    document.getElementById('emailError').classList.add('hidden');
});

document.getElementById('password').addEventListener('input', function() {
    this.classList.remove('input-error', 'shake');
    document.getElementById('passwordError').classList.add('hidden');
});

// Show server validation errors as toast
@if($errors->any())
    @foreach($errors->all() as $error)
        showToast('{{ addslashes($error) }}', 'error');
    @endforeach
@endif

@if(session('error'))
    showToast('{{ addslashes(session("error")) }}', 'error');
@endif

@if(session('success'))
    showToast('{{ addslashes(session("success")) }}', 'success');
@endif

@if(session('warning'))
    showToast('{{ addslashes(session("warning")) }}', 'warning');
@endif
</script>
@endsection
