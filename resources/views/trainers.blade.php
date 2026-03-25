@extends('layouts.dashboard')

@section('title', 'Trainers')
@section('header_title', 'Our Trainers')
@section('header_subtitle', 'Manage fitness instructors, schedules, and assignments.')

@section('header_actions')
<button onclick="openAddModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all hover:scale-105 flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
    Hire Trainer
</button>
@endsection

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center shadow-sm" id="success-alert">
    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="font-bold">{{ session('success') }}</span>
</div>
<script>setTimeout(() => document.getElementById('success-alert')?.remove(), 3000);</script>
@endif

<!-- Filter tabs -->
<div class="mb-8 flex space-x-6 border-b border-slate-200 overflow-x-auto">
    <a href="{{ route('trainers.index') }}" class="pb-3 border-b-2 {{ !$role ? 'border-orange-500 text-orange-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} font-extrabold text-sm px-1 whitespace-nowrap transition-colors">All Trainers</a>
    <a href="{{ route('trainers.index', ['role' => 'Yoga']) }}" class="pb-3 border-b-2 {{ $role == 'Yoga' ? 'border-orange-500 text-orange-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} font-bold text-sm px-1 whitespace-nowrap transition-colors">Yoga</a>
    <a href="{{ route('trainers.index', ['role' => 'CrossFit']) }}" class="pb-3 border-b-2 {{ $role == 'CrossFit' ? 'border-orange-500 text-orange-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} font-bold text-sm px-1 whitespace-nowrap transition-colors">CrossFit</a>
    <a href="{{ route('trainers.index', ['role' => 'Cardio']) }}" class="pb-3 border-b-2 {{ $role == 'Cardio' ? 'border-orange-500 text-orange-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} font-bold text-sm px-1 whitespace-nowrap transition-colors">Cardio</a>
    <a href="{{ route('trainers.index', ['role' => 'Strength']) }}" class="pb-3 border-b-2 {{ $role == 'Strength' ? 'border-orange-500 text-orange-600' : 'border-transparent text-slate-500 hover:text-slate-800' }} font-bold text-sm px-1 whitespace-nowrap transition-colors">Strength</a>
</div>

<!-- Trainers Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($trainers as $trainer)
    <div class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/40 border border-slate-100 flex flex-col items-center text-center group transition-all hover:-translate-y-1 hover:shadow-2xl hover:shadow-orange-500/10 relative">
        <!-- Edit / Delete Tools (Visible on Hover) -->
        <div class="absolute top-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <button onclick="openEditModal({{ json_encode($trainer) }})" class="text-slate-400 hover:text-indigo-500 transition-colors p-2 bg-slate-50 hover:bg-white rounded-xl border border-transparent hover:border-slate-100 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
            <button onclick="openDeleteModal({{ $trainer->id }}, '{{ addslashes($trainer->name) }}')" class="text-slate-400 hover:text-red-500 transition-colors p-2 bg-slate-50 hover:bg-white rounded-xl border border-transparent hover:border-slate-100 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </div>

        <!-- Avatar and Status Badge -->
        <div class="relative mb-6">
            <div class="w-24 h-24 rounded-full p-1 border-2 border-orange-100 group-hover:border-orange-500 transition-colors bg-white shadow-inner">
                <img class="w-full h-full rounded-full object-cover shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode($trainer->name) }}&background=f1f5f9" alt="{{ $trainer->name }}">
            </div>
            <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full border-4 border-white shadow-sm {{ $trainer->status == 'Online' ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
        </div>
        
        <h3 class="text-xl font-extrabold text-slate-900 group-hover:text-orange-500 transition-colors tracking-tight">{{ $trainer->name }}</h3>
        <p class="text-sm font-bold text-orange-500 mt-2 uppercase tracking-widest">{{ $trainer->role }}</p>
        
        <div class="mt-4 flex items-center justify-center space-x-2">
            <span class="w-1.5 h-1.5 rounded-full {{ $trainer->status == 'Online' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
            <span class="text-xs font-extrabold {{ $trainer->status == 'Online' ? 'text-emerald-600' : 'text-slate-500' }} uppercase tracking-wider">{{ $trainer->status }} NOW</span>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col items-center justify-center">
        <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        <p class="text-xl font-bold text-slate-500">No trainers found</p>
        <p class="text-sm text-slate-400 mt-2">Try adjusting your filters or hire a new trainer.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($trainers->hasPages())
<div class="mt-8 flex items-center justify-between text-sm">
    {{ $trainers->appends(['role' => $role])->links() }}
</div>
@endif

<!-- Add/Edit Modal Container -->
<div id="trainer-modal" class="{{ (isset($errors) && $errors->any()) ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100">
            <form id="trainer-form" action="{{ route('trainers.store') }}" method="POST">
                @csrf
                <div id="form-method"></div>
                
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-orange-100 sm:mx-0 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="modal-title">Hire Trainer</h3>
                            <div class="mt-6 space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Full Name</label>
                                    <input type="text" name="name" id="trainer_name" value="{{ old('name') }}" placeholder="John Doe" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Role / Specialization</label>
                                    <select name="role" id="trainer_role" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('role') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                        <option value="Yoga" {{ old('role') == 'Yoga' ? 'selected' : '' }}>Yoga Instructor</option>
                                        <option value="CrossFit" {{ old('role') == 'CrossFit' ? 'selected' : '' }}>CrossFit Coach</option>
                                        <option value="Cardio" {{ old('role') == 'Cardio' ? 'selected' : '' }}>Cardio Specialist</option>
                                        <option value="Strength" {{ old('role') == 'Strength' ? 'selected' : '' }}>Strength & Conditioning</option>
                                        <option value="Pilates" {{ old('role') == 'Pilates' ? 'selected' : '' }}>Pilates Instructor</option>
                                    </select>
                                    @error('role') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Availability Status</label>
                                    <select name="status" id="trainer_status" class="w-full px-4 py-3 rounded-xl border {{ $errors->has('status') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                        <option value="Online" {{ old('status') == 'Online' ? 'selected' : '' }}>🟢 Online (Available)</option>
                                        <option value="Offline" {{ old('status') == 'Offline' ? 'selected' : '' }}>🔴 Offline (Unavailable)</option>
                                    </select>
                                    @error('status') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-6 sm:flex sm:flex-row-reverse rounded-b-3xl border-t border-slate-100 gap-3">
                    <button type="submit" id="submit-btn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-xl shadow-orange-500/20 px-6 py-3 bg-orange-500 text-sm font-bold text-white hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-500/20 sm:w-auto transition-all">
                        Onboard Trainer
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-200 shadow-sm px-6 py-3 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>
        <div class="relative inline-block align-middle bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-md w-full border border-slate-100">
            <div class="bg-white px-6 pt-8 pb-6 text-center">
                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-100 mb-6">
                    <svg class="h-10 w-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-3">Terminate Contract?</h3>
                <p class="text-slate-500 font-medium px-4">Are you sure you want to remove <span id="delete-trainer-name" class="text-slate-900 font-bold underline decoration-red-200 decoration-4"></span> from the system? This action cannot be reversed.</p>
            </div>
            <div class="bg-slate-50 px-6 py-6 border-t border-slate-100 flex flex-col sm:flex-row-reverse gap-3">
                <form id="delete-form" action="" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-3 bg-red-600 text-sm font-bold text-white hover:bg-red-700 shadow-xl shadow-red-600/20 transition-all">
                        Yes, Remove Trainer
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-200 px-6 py-3 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    No, Keep Trainer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('trainer-modal');
    const form = document.getElementById('trainer-form');
    const methodDiv = document.getElementById('form-method');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');
    
    function openAddModal() {
        title.innerText = "Hire New Trainer";
        submitBtn.innerText = "Onboard Trainer";
        form.action = "{{ route('trainers.store') }}";
        methodDiv.innerHTML = "";
        
        // Clear fields
        ['name', 'role', 'status'].forEach(id => {
            const el = document.getElementById('trainer_' + id);
            if (el) el.value = el.options ? el.options[0].value : '';
        });
        
        modal.classList.remove('hidden');
    }

    function openEditModal(trainer) {
        title.innerText = "Update Trainer Record";
        submitBtn.innerText = "Save Changes";
        form.action = `/trainers/${trainer.id}`;
        methodDiv.innerHTML = '@method("PUT")';
        
        document.getElementById('trainer_name').value = trainer.name;
        document.getElementById('trainer_role').value = trainer.role;
        document.getElementById('trainer_status').value = trainer.status;
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-trainer-name').innerText = name;
        document.getElementById('delete-form').action = `/trainers/${id}`;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>

@endsection
