@extends('layouts.app')

@section('title', 'Teacher Dashboard')

@section('content')
{{-- Page Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold">Teacher Dashboard</h1>
        <p class="text-base-content/60 mt-1">Manage question banks, edit exam settings, and publish active tests.</p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('modalGroup').showModal()">
        <i class="fa-solid fa-plus"></i> New Question Group
    </button>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-primary">
            <i class="fa-solid fa-book text-3xl"></i>
        </div>
        <div class="stat-title">Question Groups</div>
        <div class="stat-value text-primary">{{ $groupsCount }}</div>
        <div class="stat-desc">Total bank soal</div>
    </div>
    
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-secondary">
            <i class="fa-solid fa-file-lines text-3xl"></i>
        </div>
        <div class="stat-title">Published Exams</div>
        <div class="stat-value text-secondary">{{ $examsCount }}</div>
        <div class="stat-desc">Ujian aktif</div>
    </div>
    
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-accent">
            <i class="fa-solid fa-question-circle text-3xl"></i>
        </div>
        <div class="stat-title">Total Questions</div>
        <div class="stat-value text-accent">{{ $questionGroups->sum('questions_count') }}</div>
        <div class="stat-desc">Semua soal</div>
    </div>
    
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-success">
            <i class="fa-solid fa-graduation-cap text-3xl"></i>
        </div>
        <div class="stat-title">Subjects</div>
        <div class="stat-value text-success">{{ $subjects->count() }}</div>
        <div class="stat-desc">Mata pelajaran</div>
    </div>
</div>

{{-- Question Banks Section --}}
<div id="question-banks" class="card bg-base-100 shadow-sm border border-base-300 mb-6">
    <div class="card-body p-0">
        <div class="flex items-center justify-between p-4 border-b border-base-300">
            <h2 class="card-title">
                <i class="fa-solid fa-book text-primary"></i>
                Question Banks
            </h2>
            <span class="badge badge-ghost">{{ $questionGroups->count() }} groups</span>
        </div>
        
        @if($questionGroups->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Group Name</th>
                            <th>Subject</th>
                            <th>Questions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questionGroups as $g)
                            <tr>
                                <td>
                                    <div class="font-medium">{{ $g->name }}</div>
                                    @if($g->description)
                                        <div class="text-xs text-base-content/50 mt-1">{{ Str::limit($g->description, 50) }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-outline badge-sm">{{ $g->subject->code ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="font-mono">{{ $g->questions_count }}</span>
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <a href="{{ route('teacher.question-groups.show', $g->id) }}" class="btn btn-sm btn-ghost btn-square" title="Manage Questions">
                                            <i class="fa-solid fa-pen-to-square text-primary"></i>
                                        </a>
                                        <form action="{{ route('teacher.question-groups.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bank soal ini beserta semua soal di dalamnya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost btn-square" title="Delete">
                                                <i class="fa-solid fa-trash-can text-error"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-base-content/50">
                <i class="fa-solid fa-book-open text-4xl mb-3"></i>
                <p>No question groups created yet.</p>
                <p class="text-sm mt-1">Click "New Question Group" to create your first bank.</p>
            </div>
        @endif
    </div>
</div>

{{-- Published Exams Section --}}
<div id="exams" class="card bg-base-100 shadow-sm border border-base-300 mb-6">
    <div class="card-body p-0">
        <div class="flex items-center justify-between p-4 border-b border-base-300">
            <h2 class="card-title">
                <i class="fa-solid fa-file-lines text-secondary"></i>
                Published Exams
            </h2>
            <span class="badge badge-ghost">{{ $exams->count() }} exams</span>
        </div>
        
        @if($exams->count() > 0)
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Exam Title</th>
                            <th>Question Bank</th>
                            <th>Token</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $index => $ex)
                            <tr>
                                <td class="text-base-content/50">{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-medium">{{ $ex->title }}</div>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $ex->questionGroup->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <code class="badge badge-primary badge-outline font-mono">{{ $ex->token }}</code>
                                </td>
                                <td>{{ $ex->duration_minutes }} min</td>
                                <td>
                                    @if($ex->is_active)
                                        <span class="badge badge-success gap-1">
                                            <i class="fa-solid fa-circle text-[8px]"></i> Active
                                        </span>
                                    @else
                                        <span class="badge badge-error gap-1">
                                            <i class="fa-solid fa-circle text-[8px]"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-sm btn-ghost btn-square" onclick="openEditExamModal({{ json_encode($ex) }})" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-primary"></i>
                                        </button>
                                        <form action="{{ route('teacher.exams.destroy', $ex->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus publikasi ujian ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-ghost btn-square" title="Delete">
                                                <i class="fa-solid fa-trash-can text-error"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-base-content/50">
                <i class="fa-solid fa-file-circle-plus text-4xl mb-3"></i>
                <p>No exams published yet.</p>
                <p class="text-sm mt-1">Use the form below to publish your first exam.</p>
            </div>
        @endif
    </div>
</div>

{{-- Publish New Exam --}}
<div class="card bg-base-100 shadow-sm border border-base-300">
    <div class="card-body">
        <h2 class="card-title mb-4">
            <i class="fa-solid fa-plus-circle text-accent"></i>
            Publish New Exam
        </h2>
        
        <form action="{{ route('teacher.exams.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Question Bank --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Question Bank</span>
                    </label>
                    <select name="question_group_id" class="select select-bordered w-full" required>
                        <option value="" disabled selected>Select question bank</option>
                        @foreach($questionGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} ({{ $group->questions_count }} questions)</option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Exam Title --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Exam Title</span>
                    </label>
                    <input type="text" name="title" class="input input-bordered w-full" placeholder="Midterm CS101" required>
                </div>
                
                {{-- Token --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Exam Token</span>
                    </label>
                    <div class="join w-full">
                        <input type="text" name="token" id="examTokenInput" class="input input-bordered join-item flex-1 uppercase" placeholder="EXAM26" required>
                        <button type="button" class="btn btn-secondary join-item" onclick="generateToken()" title="Generate Random Token">
                            <i class="fa-solid fa-wand-magic-sparkles"></i>
                        </button>
                    </div>
                </div>
                
                {{-- Duration --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-medium">Duration (Minutes)</span>
                    </label>
                    <input type="number" name="duration_minutes" class="input input-bordered w-full" value="60" min="5" required>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <button type="submit" class="btn btn-accent w-full">
                <i class="fa-solid fa-paper-plane"></i> Publish Exam
            </button>
        </form>
    </div>
</div>

{{-- Create Question Group Modal --}}
<dialog id="modalGroup" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">
            <i class="fa-solid fa-folder-plus text-primary"></i>
            Create Question Group
        </h3>
        
        <form action="{{ route('teacher.question-groups.store') }}" method="POST">
            @csrf
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">Group Name</span>
                </label>
                <input type="text" name="name" class="input input-bordered w-full" placeholder="Web Development Basics" required>
            </div>
            
            @if($subjects->count() > 0)
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-medium">Subject / Mata Pelajaran</span>
                    </label>
                    <select name="subject_id" class="select select-bordered w-full">
                        @foreach($subjects as $subj)
                            <option value="{{ $subj->id }}">{{ $subj->name }} ({{ $subj->code }})</option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            <div class="form-control mb-6">
                <label class="label">
                    <span class="label-text font-medium">Description</span>
                </label>
                <textarea name="description" class="textarea textarea-bordered h-24" placeholder="Description or target chapter..."></textarea>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modalGroup').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Create Group
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

{{-- Edit Exam Modal --}}
<dialog id="modalEditExam" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">
            <i class="fa-solid fa-pen-to-square text-primary"></i>
            Edit Published Exam
        </h3>
        
        <form id="editExamForm" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">Judul Ujian</span>
                </label>
                <input type="text" name="title" id="edit_title" class="input input-bordered w-full" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">Token Ujian</span>
                </label>
                <input type="text" name="token" id="edit_token" class="input input-bordered w-full uppercase" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">Durasi (Menit)</span>
                </label>
                <input type="number" name="duration_minutes" id="edit_duration_minutes" class="input input-bordered w-full" min="1" required>
            </div>
            
            <div class="form-control mb-6">
                <label class="label">
                    <span class="label-text font-medium">Status Ujian</span>
                </label>
                <select name="is_active" id="edit_is_active" class="select select-bordered w-full">
                    <option value="1">Aktif (Peserta Bisa Akses)</option>
                    <option value="0">Nonaktif (Dipause / Ditutup)</option>
                </select>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modalEditExam').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection

@section('scripts')
<script>
function openEditExamModal(exam) {
    const form = document.getElementById('editExamForm');
    const titleInput = document.getElementById('edit_title');
    const tokenInput = document.getElementById('edit_token');
    const durationInput = document.getElementById('edit_duration_minutes');
    const activeSelect = document.getElementById('edit_is_active');

    form.action = `/teacher/exams/${exam.id}`;
    titleInput.value = exam.title || '';
    tokenInput.value = exam.token || '';
    durationInput.value = exam.duration_minutes || 60;
    activeSelect.value = exam.is_active ? '1' : '0';

    document.getElementById('modalEditExam').showModal();
}

function generateToken() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let token = '';
    for (let i = 0; i < 6; i++) {
        token += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('examTokenInput').value = token;
}
</script>
@endsection
