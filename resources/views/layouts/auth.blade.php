<!DOCTYPE html>
<html lang="en" data-theme="corporate">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Platform Ujian Online Terbuka berkecepatan tinggi, aman, dan mudah diakses.')">
    <meta name="keywords" content="ujian online, cbt, computer based test, aplikasi ujian sekolah, open source, laravel, pendidikan">
    <meta name="author" content="Achmad An'im">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Beranda') - Ajenono Exam Platform">
    <meta property="og:description" content="@yield('meta_description', 'Platform Ujian Online Terbuka berkecepatan tinggi, aman, dan mudah diakses.')">
    <meta property="og:image" content="{{ asset('favicon.svg') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <title>@yield('title', 'Exam System') - Ajenono Exam Platform</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        @font-face {
            font-family: 'KFGQPC Uthman Taha Naskh';
            src: url("{{ asset('vendor/KFGQPC Uthman Taha Naskh Regular.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
            unicode-range: U+0600-06FF, U+0750-077F, U+08A0-08FF, U+FB50-FDFF, U+FE70-FEFF;
        }

        /* RTL Support */
        [dir="rtl"] { text-align: right; direction: rtl; font-family: 'KFGQPC Uthman Taha Naskh', 'Amiri', serif; line-height: 2; }
        [dir="auto"] { text-align: start; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: oklch(var(--b2)); }
        ::-webkit-scrollbar-thumb { background: oklch(var(--bc) / 0.2); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: oklch(var(--bc) / 0.4); }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen bg-base-100 selection:bg-primary/20 selection:text-primary">
    {{-- Flash messages --}}
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50">
            <div class="alert alert-success shadow-lg max-w-sm">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    @if(session('error') || $errors->any())
        <div class="fixed top-4 right-4 z-50">
            <div class="alert alert-error shadow-lg max-w-sm">
                <i class="fa-solid fa-circle-xmark"></i>
                <div>
                    @if(session('error')) {{ session('error') }} @endif
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="fixed top-4 right-4 z-50">
            <div class="alert alert-warning shadow-lg max-w-sm">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ session('warning') }}</span>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="fixed top-4 right-4 z-50">
            <div class="alert alert-info shadow-lg max-w-sm">
                <i class="fa-solid fa-circle-info"></i>
                <span>{{ session('info') }}</span>
            </div>
        </div>
    @endif

    @yield('content')

    {{-- Theme toggle (floating) --}}
    <div class="fixed bottom-4 right-4 z-50">
        <label class="swap swap-rotate btn btn-circle btn-sm btn-ghost bg-base-100/80 backdrop-blur shadow-sm border border-base-300">
            <input type="checkbox" id="themeToggle" onchange="toggleTheme(this.checked)" />
            <i class="fa-solid fa-sun swap-on text-sm"></i>
            <i class="fa-solid fa-moon swap-off text-sm"></i>
        </label>
    </div>

    {{-- Scripts --}}
    <script>
        function toggleTheme(isDark) {
            const theme = isDark ? 'dark' : 'corporate';
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('exam_theme', theme);
        }

        function applyTheme() {
            const saved = localStorage.getItem('exam_theme') || 'corporate';
            const isDark = saved === 'dark';
            document.documentElement.setAttribute('data-theme', saved);
            const toggle = document.getElementById('themeToggle');
            if (toggle) toggle.checked = isDark;
        }

        document.addEventListener('DOMContentLoaded', applyTheme);

        // Auto-dismiss flash messages
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                el.style.transition = 'opacity 0.3s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            });
        }, 5000);
    </script>

    @yield('scripts')
</body>
</html>
