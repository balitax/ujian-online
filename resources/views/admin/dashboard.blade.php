@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold">School Overview</h1>
    <p class="text-base-content/60 mt-1">{{ $school->name }} - Manage academic records, teachers, and students.</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-primary">
            <i class="fa-solid fa-chalkboard-user text-3xl"></i>
        </div>
        <div class="stat-title">Teachers</div>
        <div class="stat-value text-primary">{{ $teachersCount }}</div>
        <div class="stat-desc">Total guru</div>
    </div>
    
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-secondary">
            <i class="fa-solid fa-user-graduate text-3xl"></i>
        </div>
        <div class="stat-title">Students</div>
        <div class="stat-value text-secondary">{{ $studentsCount }}</div>
        <div class="stat-desc">Total siswa</div>
    </div>
    
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-accent">
            <i class="fa-solid fa-school text-3xl"></i>
        </div>
        <div class="stat-title">Classrooms</div>
        <div class="stat-value text-accent">{{ $classroomsCount }}</div>
        <div class="stat-desc">Total kelas</div>
    </div>
    
    <div class="stat bg-base-100 rounded-box shadow-sm border border-base-300">
        <div class="stat-figure text-success">
            <i class="fa-solid fa-book text-3xl"></i>
        </div>
        <div class="stat-title">Subjects</div>
        <div class="stat-value text-success">{{ $subjectsCount }}</div>
        <div class="stat-desc">Mata pelajaran</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Quick Actions --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body">
            <h2 class="card-title mb-4">
                <i class="fa-solid fa-bolt text-warning"></i>
                Quick Actions
            </h2>
            
            <div class="grid grid-cols-1 gap-3">
                <a href="{{ route('admin.teachers') }}" class="btn btn-outline btn-primary justify-start gap-3">
                    <i class="fa-solid fa-chalkboard-user w-5"></i>
                    <div class="text-left">
                        <div class="font-medium">Manage Teachers</div>
                        <div class="text-xs opacity-60">Add, edit, or remove teacher accounts</div>
                    </div>
                </a>
                
                <a href="{{ route('admin.students') }}" class="btn btn-outline btn-secondary justify-start gap-3">
                    <i class="fa-solid fa-user-graduate w-5"></i>
                    <div class="text-left">
                        <div class="font-medium">Manage Students</div>
                        <div class="text-xs opacity-60">Add, edit, or remove student accounts</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- School Info --}}
    <div class="card bg-base-100 shadow-sm border border-base-300">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h2 class="card-title">
                    <i class="fa-solid fa-school text-primary"></i>
                    School Information
                </h2>
                <button class="btn btn-sm btn-ghost" onclick="document.getElementById('editSchoolModal').showModal()">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </button>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                    <i class="fa-solid fa-building text-base-content/40 w-5"></i>
                    <div>
                        <div class="text-xs text-base-content/50">School Name</div>
                        <div class="font-medium">{{ $school->name }}</div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                    <i class="fa-solid fa-tag text-base-content/40 w-5"></i>
                    <div>
                        <div class="text-xs text-base-content/50">School Code</div>
                        <div class="font-mono font-medium">{{ $school->code ?? 'N/A' }}</div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                    <i class="fa-solid fa-envelope text-base-content/40 w-5"></i>
                    <div>
                        <div class="text-xs text-base-content/50">Email</div>
                        <div class="font-medium">{{ $school->email }}</div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 p-3 bg-base-200 rounded-lg">
                    <i class="fa-solid fa-phone text-base-content/40 w-5"></i>
                    <div>
                        <div class="text-xs text-base-content/50">Phone</div>
                        <div class="font-medium">{{ $school->phone ?? 'Not specified' }}</div>
                    </div>
                </div>
                
                <div class="flex items-start gap-3 p-3 bg-base-200 rounded-lg">
                    <i class="fa-solid fa-location-dot text-base-content/40 w-5 mt-1"></i>
                    <div>
                        <div class="text-xs text-base-content/50">Address</div>
                        <div class="font-medium">{{ $school->address ?? 'Not specified' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit School Modal --}}
<dialog id="editSchoolModal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">
            <i class="fa-solid fa-pen-to-square text-primary"></i>
            Update School Profile
        </h3>
        
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">School Name</span>
                </label>
                <input type="text" name="name" class="input input-bordered w-full" value="{{ old('name', $school->name) }}" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">School Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered w-full" value="{{ old('email', $school->email) }}" required>
            </div>
            
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text font-medium">Phone Number</span>
                </label>
                <input type="text" name="phone" class="input input-bordered w-full" value="{{ old('phone', $school->phone) }}" placeholder="e.g. (021) 555-1234">
            </div>
            
            <div class="form-control mb-6">
                <label class="label">
                    <span class="label-text font-medium">School Address</span>
                </label>
                <textarea name="address" class="textarea textarea-bordered h-24" placeholder="Enter complete school address...">{{ old('address', $school->address) }}</textarea>
            </div>
            
            <div class="modal-action">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('editSchoolModal').close()">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
@endsection
