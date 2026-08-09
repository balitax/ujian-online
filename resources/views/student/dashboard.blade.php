@extends('layouts.app')

@section('title', 'Student Portal')

@section('content')
{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }} 👋</h1>
    <p class="text-base-content/60 mt-1">Enter token to join an ongoing exam or view your exam history.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Enter Exam Token Card --}}
    <div id="enter-token" class="lg:col-span-1">
        <div class="card bg-base-100 shadow-sm border border-primary/30 h-full">
            <div class="card-body">
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-3 bg-primary/10 rounded-xl">
                        <i class="fa-solid fa-key text-xl text-primary"></i>
                    </div>
                    <div>
                        <h2 class="card-title text-lg">Enter Exam Token</h2>
                        <p class="text-xs text-base-content/50">6-character token from your teacher</p>
                    </div>
                </div>
                
                <form action="{{ route('student.enter-token') }}" method="POST">
                    @csrf
                    <div class="form-control mb-4">
                        <input 
                            type="text" 
                            id="token" 
                            name="token" 
                            class="input input-bordered input-lg w-full text-center text-2xl font-mono uppercase tracking-[0.3em]" 
                            placeholder="------" 
                            maxlength="6"
                            required
                        >
                    </div>
                    <button type="submit" class="btn btn-primary w-full">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Start Exam Session
                    </button>
                </form>
                
                {{-- Quick Tips --}}
                <div class="divider text-xs">Tips</div>
                <ul class="text-xs text-base-content/50 space-y-2">
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-circle-info mt-0.5"></i>
                        <span>Get the token from your teacher</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-clock mt-0.5"></i>
                        <span>Make sure you have enough time</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-wifi mt-0.5"></i>
                        <span>Ensure stable internet connection</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    {{-- Exam History & Results --}}
    <div class="lg:col-span-2">
        <div class="card bg-base-100 shadow-sm border border-base-300 h-full">
            <div class="card-body p-0">
                <div class="flex items-center justify-between p-4 border-b border-base-300">
                    <h2 class="card-title">
                        <i class="fa-solid fa-chart-column text-secondary"></i>
                        My Exam Results
                    </h2>
                    <span class="badge badge-ghost">{{ $myResults->count() }} exams</span>
                </div>
                
                @if($myResults->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>Exam Title</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myResults as $res)
                                    <tr>
                                        <td>
                                            <div class="font-medium">{{ $res->exam->title }}</div>
                                        </td>
                                        <td>
                                            <div class="text-sm">{{ $res->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-base-content/50">{{ $res->created_at->format('H:i') }}</div>
                                        </td>
                                        <td>
                                            @if($res->status === 'graded' || $res->status === 'submitted')
                                                <span class="badge badge-success gap-1">
                                                    <i class="fa-solid fa-check text-[8px]"></i> Selesai
                                                </span>
                                            @else
                                                <span class="badge badge-warning gap-1">
                                                    <i class="fa-solid fa-clock text-[8px]"></i> In Progress
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($res->score !== null)
                                                @php
                                                    $scoreColor = $res->score >= 80 ? 'text-success' : ($res->score >= 60 ? 'text-warning' : 'text-error');
                                                @endphp
                                                <span class="font-bold text-lg {{ $scoreColor }}">{{ $res->score }}%</span>
                                            @else
                                                <span class="text-base-content/40">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Summary Stats --}}
                    @if($myResults->where('status', 'graded')->count() > 0)
                        <div class="p-4 border-t border-base-300 bg-base-200/50">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-base-content/60">Average Score</span>
                                @php
                                    $avgScore = $myResults->where('status', 'graded')->avg('score');
                                    $avgColor = $avgScore >= 80 ? 'text-success' : ($avgScore >= 60 ? 'text-warning' : 'text-error');
                                @endphp
                                <span class="font-bold {{ $avgColor }}">{{ number_format($avgScore, 1) }}%</span>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="p-8 text-center text-base-content/50">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-base-200 rounded-full mb-4">
                            <i class="fa-solid fa-clipboard-list text-3xl"></i>
                        </div>
                        <p class="font-medium">No exam history yet</p>
                        <p class="text-sm mt-1">Enter a token above to begin your first exam.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Available Exams (if any) --}}
@if(isset($availableExams) && $availableExams->count() > 0)
    <div class="mt-6">
        <div class="card bg-base-100 shadow-sm border border-base-300">
            <div class="card-body p-0">
                <div class="flex items-center justify-between p-4 border-b border-base-300">
                    <h2 class="card-title">
                        <i class="fa-solid fa-file-circle-check text-accent"></i>
                        Available Exams
                    </h2>
                    <span class="badge badge-accent">{{ $availableExams->count() }} exams</span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @foreach($availableExams as $exam)
                        <div class="card bg-base-200 shadow-sm border border-base-300 hover:border-primary/30 transition-colors">
                            <div class="card-body p-4">
                                <h3 class="font-bold text-sm">{{ $exam->title }}</h3>
                                <div class="flex items-center gap-4 mt-2 text-xs text-base-content/60">
                                    <span><i class="fa-solid fa-clock"></i> {{ $exam->duration_minutes }} min</span>
                                    <span><i class="fa-solid fa-book"></i> {{ $exam->questionGroup->name ?? 'N/A' }}</span>
                                </div>
                                <div class="mt-3">
                                    <code class="badge badge-primary badge-outline badge-sm font-mono">{{ $exam->token }}</code>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
