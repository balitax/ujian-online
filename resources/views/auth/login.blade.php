@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Logo & Title --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-2xl mb-4">
                <i class="fa-solid fa-graduation-cap text-3xl text-primary"></i>
            </div>
            <h1 class="text-2xl font-bold">Welcome Back</h1>
            <p class="text-base-content/60 mt-1">Sign in to your exam platform</p>
        </div>
        
        {{-- Login Card --}}
        <div class="card bg-base-100 shadow-xl border border-base-300">
            <div class="card-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    {{-- Email --}}
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-medium">Email Address</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="input input-bordered w-full pl-10" 
                                placeholder="user@school.org" 
                                value="{{ old('email') }}" 
                                required 
                                autofocus
                            >
                            <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40"></i>
                        </div>
                    </div>
                    
                    {{-- Password --}}
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text font-medium">Password</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="input input-bordered w-full pl-10" 
                                placeholder="••••••••" 
                                required
                            >
                            <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-base-content/40"></i>
                        </div>
                    </div>
                    
                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between mb-6">
                        <label class="label cursor-pointer gap-2">
                            <input type="checkbox" id="remember" name="remember" class="checkbox checkbox-sm checkbox-primary" />
                            <span class="label-text">Remember me</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="link link-primary text-sm">Forgot Password?</a>
                    </div>
                    
                    {{-- Turnstile CAPTCHA --}}
                    @if(config('services.turnstile.site_key'))
                        <div class="flex justify-center mb-6">
                            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                        </div>
                        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                    @endif
                    
                    {{-- Submit --}}
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fa-solid fa-right-to-bracket"></i> Sign In
                    </button>
                </form>
            </div>
        </div>
        
        {{-- Links --}}
        <div class="text-center mt-6 space-y-2">
            <p class="text-sm text-base-content/60">
                New School? 
                <a href="{{ route('register.school') }}" class="link link-primary font-medium">Register your School Account</a>
            </p>
            <p class="text-sm text-base-content/60">
                Didn't receive verification email? 
                <a href="{{ route('verification.resend.show') }}" class="link link-accent">Resend Verification Link</a>
            </p>
        </div>
        
        {{-- Demo Accounts --}}
        <div class="divider mt-8">Demo Accounts</div>
        <div class="grid grid-cols-1 gap-2 text-sm">
            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                <div>
                    <span class="badge badge-primary badge-sm mr-2">Admin</span>
                    <span class="font-mono text-xs">admin@demo.org</span>
                </div>
                <span class="text-base-content/40">password</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                <div>
                    <span class="badge badge-secondary badge-sm mr-2">Teacher</span>
                    <span class="font-mono text-xs">teacher@demo.org</span>
                </div>
                <span class="text-base-content/40">password</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                <div>
                    <span class="badge badge-accent badge-sm mr-2">Student</span>
                    <span class="font-mono text-xs">student@demo.org</span>
                </div>
                <span class="text-base-content/40">password</span>
            </div>
        </div>
    </div>
</div>
@endsection
