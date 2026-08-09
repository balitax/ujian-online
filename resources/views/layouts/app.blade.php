<!DOCTYPE html>
<html lang="en" data-theme="light">
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

        /* Toast animation */
        @keyframes toast-slide-in {
            from { opacity: 0; transform: translateY(-12px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .toast-animate-in { animation: toast-slide-in 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen bg-base-200">
    {{-- Navbar --}}
    <div class="navbar bg-base-100 shadow-sm sticky top-0 z-50 border-b border-base-300">
        <div class="navbar-start">
            {{-- Mobile menu button --}}
            @auth
                <label for="main-drawer" class="btn btn-ghost lg:hidden">
                    <i class="fa-solid fa-bars text-lg"></i>
                </label>
            @endauth
            
            <a href="{{ url('/') }}" class="btn btn-ghost text-xl font-bold gap-2">
                <i class="fa-solid fa-graduation-cap text-primary"></i>
                <span class="hidden sm:inline">Ajenono</span>
            </a>
        </div>
        
        <div class="navbar-end gap-2">
            @auth
                {{-- Theme toggle --}}
                <label class="swap swap-rotate btn btn-ghost btn-circle">
                    <input type="checkbox" id="themeToggle" onchange="toggleTheme(this.checked)" />
                    <i class="fa-solid fa-sun swap-on text-lg"></i>
                    <i class="fa-solid fa-moon swap-off text-lg"></i>
                </label>
                
                {{-- User dropdown --}}
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost gap-2">
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-8">
                                <span class="text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <span class="hidden md:inline text-sm">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-50 w-52 p-2 shadow-lg border border-base-300 mt-2">
                        <li class="menu-title">
                            <span>{{ ucfirst(Auth::user()->role) }}</span>
                        </li>
                        <li>
                            <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : (Auth::user()->isTeacher() ? route('teacher.dashboard') : route('student.dashboard')) }}">
                                <i class="fa-solid fa-gauge"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-error">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <label class="swap swap-rotate btn btn-ghost btn-circle">
                    <input type="checkbox" id="themeToggle" onchange="toggleTheme(this.checked)" />
                    <i class="fa-solid fa-sun swap-on text-lg"></i>
                    <i class="fa-solid fa-moon swap-off text-lg"></i>
                </label>
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Login</a>
                <a href="{{ route('register.school') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-school"></i> Register School
                </a>
            @endauth
        </div>
    </div>

    {{-- Main content with drawer for authenticated users --}}
    @auth
        <div class="drawer lg:drawer-open">
            <input id="main-drawer" type="checkbox" class="drawer-toggle" />
            
            {{-- Page content --}}
            <div class="drawer-content">
                <div class="p-4 lg:p-6 max-w-7xl mx-auto">
                    {{-- Flash messages --}}
                    @if(session('success'))
                        <div class="alert alert-success mb-4 shadow-sm">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    
                    @if(session('error') || $errors->any())
                        <div class="alert alert-error mb-4 shadow-sm">
                            <i class="fa-solid fa-circle-xmark"></i>
                            <div>
                                @if(session('error')) {{ session('error') }} @endif
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning mb-4 shadow-sm">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            <span>{{ session('warning') }}</span>
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="alert alert-info mb-4 shadow-sm">
                            <i class="fa-solid fa-circle-info"></i>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
            
            {{-- Sidebar --}}
            <div class="drawer-side z-40">
                <label for="main-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <aside class="bg-base-100 min-h-full w-64 border-r border-base-300">
                    {{-- Sidebar header --}}
                    <div class="p-4 border-b border-base-300">
                        <div class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-lg w-10">
                                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="font-bold text-sm">Ajenono Exam</h2>
                                <p class="text-xs text-base-content/60">{{ ucfirst(Auth::user()->role) }} Panel</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Sidebar menu --}}
                    <ul class="menu p-4 gap-1">
                        {{-- Admin Menu --}}
                        @if(Auth::user()->isAdmin())
                            <li class="menu-title">
                                <span>Main Menu</span>
                            </li>
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="fa-solid fa-gauge"></i> Dashboard
                                </a>
                            </li>
                            <li class="menu-title mt-2">
                                <span>Management</span>
                            </li>
                            <li>
                                <a href="{{ route('admin.teachers') }}" class="{{ request()->routeIs('admin.teachers') ? 'active' : '' }}">
                                    <i class="fa-solid fa-chalkboard-user"></i> Teachers
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.students') }}" class="{{ request()->routeIs('admin.students') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-graduate"></i> Students
                                </a>
                            </li>
                        
                        {{-- Teacher Menu --}}
                        @elseif(Auth::user()->isTeacher())
                            <li class="menu-title">
                                <span>Main Menu</span>
                            </li>
                            <li>
                                <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                                    <i class="fa-solid fa-gauge"></i> Dashboard
                                </a>
                            </li>
                            <li class="menu-title mt-2">
                                <span>Exam Management</span>
                            </li>
                            <li>
                                <a href="{{ route('teacher.dashboard') }}#question-banks" class="">
                                    <i class="fa-solid fa-book"></i> Question Banks
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('teacher.dashboard') }}#exams" class="">
                                    <i class="fa-solid fa-file-lines"></i> Published Exams
                                </a>
                            </li>
                        
                        {{-- Student Menu --}}
                        @else
                            <li class="menu-title">
                                <span>Main Menu</span>
                            </li>
                            <li>
                                <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                                    <i class="fa-solid fa-gauge"></i> Exam Portal
                                </a>
                            </li>
                            <li class="menu-title mt-2">
                                <span>Quick Access</span>
                            </li>
                            <li>
                                <a href="{{ route('student.dashboard') }}#enter-token">
                                    <i class="fa-solid fa-key"></i> Enter Exam Token
                                </a>
                            </li>
                        @endif
                        
                        {{-- Common --}}
                        <li class="menu-title mt-4">
                            <span>Account</span>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left text-error hover:bg-error/10">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                    
                    {{-- Sidebar footer --}}
                    <div class="p-4 border-t border-base-300 mt-auto">
                        <div class="flex items-center gap-3">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-8">
                                    <span class="text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-base-content/60 truncate">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    @else
        {{-- Guest content (no sidebar) --}}
        <div class="min-h-[calc(100vh-4rem)]">
            @if(session('success'))
                <div class="max-w-4xl mx-auto px-4 pt-4">
                    <div class="alert alert-success shadow-sm">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            
            @if(session('error') || $errors->any())
                <div class="max-w-4xl mx-auto px-4 pt-4">
                    <div class="alert alert-error shadow-sm">
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
                <div class="max-w-4xl mx-auto px-4 pt-4">
                    <div class="alert alert-warning shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ session('warning') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    @endauth

    {{-- Footer --}}
    <footer class="footer footer-center p-4 bg-base-100 text-base-content border-t border-base-300">
        <aside>
            <p class="text-sm">
                &copy; {{ date('Y') }} Ajenono Exam Platform. Made with 
                <i class="fa-solid fa-heart text-error"></i> by 
                <a href="https://github.com/animfahmy" target="_blank" rel="noopener noreferrer" class="link link-primary">Achmad An'im</a>
            </p>
        </aside>
    </footer>

    {{-- Global Scripts --}}
    <script>
        // Theme management
        function toggleTheme(isDark) {
            const theme = isDark ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('exam_theme', theme);
        }

        function applyTheme() {
            const saved = localStorage.getItem('exam_theme') || 'light';
            const isDark = saved === 'dark';
            document.documentElement.setAttribute('data-theme', saved);
            const toggle = document.getElementById('themeToggle');
            if (toggle) toggle.checked = isDark;
        }

        document.addEventListener('DOMContentLoaded', applyTheme);

        // Toast notification system
        window.ExamToast = {
            show(message, type = 'info', duration = 3500) {
                const container = document.getElementById('toast-container') || this.createContainer();
                const toast = document.createElement('div');
                
                const alertClass = {
                    success: 'alert-success',
                    error: 'alert-error',
                    warning: 'alert-warning',
                    info: 'alert-info'
                }[type] || 'alert-info';
                
                const icon = {
                    success: 'fa-circle-check',
                    error: 'fa-circle-xmark',
                    warning: 'fa-triangle-exclamation',
                    info: 'fa-circle-info'
                }[type] || 'fa-circle-info';
                
                toast.className = `alert ${alertClass} shadow-lg toast-animate-in`;
                toast.innerHTML = `<i class="fa-solid ${icon}"></i><span>${message}</span>`;
                container.appendChild(toast);
                
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-10px)';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(() => toast.remove(), 300);
                }, duration);
            },
            createContainer() {
                const container = document.createElement('div');
                container.id = 'toast-container';
                container.className = 'toast toast-top toast-end z-[9999]';
                document.body.appendChild(container);
                return container;
            },
            success(msg) { this.show(msg, 'success'); },
            error(msg) { this.show(msg, 'error'); },
            warning(msg) { this.show(msg, 'warning'); },
            info(msg) { this.show(msg, 'info'); }
        };

        // Confirm dialog
        window.ExamConfirm = function(title, text, confirmBtnText = 'Ya, Lanjutkan') {
            return new Promise((resolve) => {
                const modal = document.createElement('dialog');
                modal.className = 'modal modal-open';
                modal.innerHTML = `
                    <div class="modal-box">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-3 bg-warning/10 rounded-full">
                                <i class="fa-solid fa-triangle-exclamation text-warning text-xl"></i>
                            </div>
                            <h3 class="font-bold text-lg">${title}</h3>
                        </div>
                        <p class="text-base-content/70 mb-6">${text}</p>
                        <div class="modal-action">
                            <button class="btn btn-ghost" id="confirmCancel">Batal</button>
                            <button class="btn btn-error" id="confirmOk">${confirmBtnText}</button>
                        </div>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                `;
                document.body.appendChild(modal);
                modal.showModal();
                
                modal.querySelector('#confirmCancel').onclick = () => {
                    modal.close();
                    modal.remove();
                    resolve(false);
                };
                modal.querySelector('#confirmOk').onclick = () => {
                    modal.close();
                    modal.remove();
                    resolve(true);
                };
                modal.querySelector('.modal-backdrop').onclick = () => {
                    modal.close();
                    modal.remove();
                    resolve(false);
                };
            });
        };
    </script>

    @yield('scripts')
</body>
</html>
