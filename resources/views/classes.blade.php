@extends('layouts.dashboard')

@section('title', 'Classes')
@section('header_title', 'Class Schedule')
@section('header_subtitle', 'View and manage upcoming fitness classes and room bookings.')

@section('header_actions')
<div class="flex gap-3 items-center">
    <input type="date" onchange="window.location.href='?date='+this.value" value="{{ isset($date) ? $date : \Carbon\Carbon::today()->toDateString() }}" class="bg-white border border-slate-200 text-slate-600 px-3 py-2.5 rounded-xl font-bold transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none shadow-sm cursor-pointer hover:bg-slate-50">
    <a href="{{ route('classes.index', ['date' => \Carbon\Carbon::today()->toDateString()]) }}" class="bg-white border border-slate-200 text-slate-600 hover:text-slate-900 px-4 py-2.5 rounded-xl font-bold transition-all hover:bg-slate-50 flex items-center shadow-sm hidden sm:flex">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        Today
    </a>
    <button onclick="openAddModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all hover:scale-105 flex items-center">
        <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        <span class="hidden sm:inline">New Class</span>
    </button>
</div>
@endsection

@section('content')

@if(session('success'))
<div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center shadow-sm" id="success-alert">
    <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <span class="font-bold">{{ session('success') }}</span>
</div>
<script>setTimeout(() => document.getElementById('success-alert')?.remove(), 3000);</script>
@endif

<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
    <!-- Days Strip -->
    <div class="border-b border-slate-100 bg-slate-50/50 p-4">
        <div class="flex justify-between flex-nowrap overflow-x-auto items-center w-full max-w-4xl mx-auto space-x-2 sm:space-x-0 pb-2 sm:pb-0">
            @php
                $dates = [];
                // Create a generic 7-day strip starting from today for aesthetic realism
                $currentDate = isset($date) ? \Carbon\Carbon::parse($date) : \Carbon\Carbon::today();
                
                for($i = 0; $i < 7; $i++) {
                    $loopDate = \Carbon\Carbon::today()->addDays($i);
                    $dates[] = [
                        'day' => $loopDate->format('D'),
                        'num' => $loopDate->format('d'),
                        'full_date' => $loopDate->toDateString(),
                        'active' => $loopDate->toDateString() === $currentDate->toDateString(), // Highlight active selected date
                    ];
                }
            @endphp
            
            @foreach($dates as $day)
            <a href="{{ route('classes.index', ['date' => $day['full_date']]) }}" class="flex flex-col items-center justify-center cursor-pointer group px-4 sm:px-6 py-2 rounded-2xl transition-all {{ $day['active'] ? 'bg-orange-500 shadow-lg shadow-orange-500/30 shrink-0' : 'hover:bg-white border border-transparent hover:border-slate-200 shrink-0' }}">
                <span class="text-xs font-bold uppercase tracking-widest {{ $day['active'] ? 'text-orange-100' : 'text-slate-400 group-hover:text-slate-600' }}">{{ $day['day'] }}</span>
                <span class="text-lg font-extrabold mt-1 {{ $day['active'] ? 'text-white' : 'text-slate-900' }}">{{ $day['num'] }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Timeline / Classes list -->
    <div class="p-6">
        <div class="max-w-4xl mx-auto relative border-l-2 border-slate-100 pl-6 sm:pl-10 py-4 space-y-10">
            
            @forelse($classes as $class)
            <div class="relative group">
                <!-- Timeline Dot -->
                <div class="absolute -left-[31px] sm:-left-[47px] top-6 w-5 h-5 rounded-full bg-white border-4 border-slate-300 group-hover:border-{{ $class->color_theme }}-500 transition-colors z-10 shadow-sm"></div>
                
                <div class="flex items-center justify-between mb-2">
                    <p class="text-xs font-extrabold text-{{ $class->color_theme }}-500 uppercase tracking-widest">
                        {{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($class->end_time)->format('h:i A') }}
                    </p>
                    
                    <!-- Admin Actions -->
                    <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick='openEditModal(@json($class))' class="text-slate-400 hover:text-indigo-500 transition-colors p-1.5 bg-slate-50 hover:bg-white rounded border border-transparent hover:border-slate-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button onclick="openDeleteModal({{ $class->id }}, '{{ addslashes($class->name) }}')" class="text-slate-400 hover:text-red-500 transition-colors p-1.5 bg-slate-50 hover:bg-white rounded border border-transparent hover:border-slate-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 group-hover:bg-white group-hover:shadow-xl group-hover:shadow-slate-200/50 transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-{{ $class->color_theme }}-100 text-{{ $class->color_theme }}-600 rounded-xl flex items-center justify-center shrink-0 font-extrabold text-xl">
                            {{ mb_substr($class->name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-lg font-extrabold text-slate-800 tracking-tight">{{ $class->name }}</h4>
                            <p class="text-sm font-medium text-slate-500 mt-0.5">{{ $class->room }} • Instructor: {{ $class->trainer->name ?? 'Unassigned' }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col sm:items-end gap-2">
                        <span class="text-xs font-bold {{ $class->enrolled >= $class->capacity ? 'text-red-500 shadow-sm border-red-200 bg-red-50' : 'text-slate-400 bg-white border-slate-200' }} px-3 py-1 rounded-full border">
                            {{ $class->enrolled }}/{{ $class->capacity }} Spots
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col items-center justify-center -ml-6 sm:-ml-10 h-64">
                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="text-xl font-bold text-slate-500">No classes scheduled</p>
                <p class="text-sm text-slate-400 mt-2">Click "New Class" to build your daily schedule.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>

<!-- Add/Edit Modal Container -->
<div id="class-modal" class="{{ (isset($errors) && $errors->any()) ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100">
            <form id="class-form" action="{{ route('classes.store') }}" method="POST">
                @csrf
                <div id="form-method"></div>
                
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-indigo-100 sm:mx-0 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="modal-title">Schedule New Class</h3>
                            <div class="mt-6 space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Class Name</label>
                                    <input type="text" name="name" id="class_name" value="{{ old('name') }}" placeholder="e.g. Morning Vinyasa Yoga" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Class Date</label>
                                    <input type="date" name="class_date" id="class_date" value="{{ old('class_date', $date ?? \Carbon\Carbon::today()->toDateString()) }}" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('class_date') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium text-slate-700">
                                    @error('class_date') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Instructor</label>
                                        <select name="trainer_id" id="class_trainer_id" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('trainer_id') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                            @foreach($trainers as $trainer)
                                                <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>{{ $trainer->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('trainer_id') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Room/Studio</label>
                                        <input type="text" name="room" id="class_room" value="{{ old('room') }}" placeholder="Studio A" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('room') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                        @error('room') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Start Time</label>
                                        <input type="time" name="start_time" id="class_start_time" value="{{ old('start_time') }}" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('start_time') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                        @error('start_time') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">End Time</label>
                                        <input type="time" name="end_time" id="class_end_time" value="{{ old('end_time') }}" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('end_time') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                        @error('end_time') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Capacity</label>
                                        <input type="number" name="capacity" id="class_capacity" value="{{ old('capacity', 20) }}" min="1" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('capacity') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                        @error('capacity') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Color Theme</label>
                                    <div class="flex gap-4">
                                        @foreach(['indigo', 'orange', 'red', 'emerald', 'amber'] as $color)
                                        <label class="relative cursor-pointer">
                                            <input type="radio" name="color_theme" value="{{ $color }}" class="peer sr-only" {{ old('color_theme', 'indigo') == $color ? 'checked' : '' }}>
                                            <div class="w-8 h-8 rounded-full bg-{{ $color }}-500 ring-2 ring-offset-2 ring-transparent peer-checked:ring-{{ $color }}-500 transition-all"></div>
                                        </label>
                                        @endforeach
                                    </div>
                                    @error('color_theme') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-6 sm:flex sm:flex-row-reverse rounded-b-3xl border-t border-slate-100 gap-3">
                    <button type="submit" id="submit-btn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-xl shadow-indigo-500/20 px-6 py-3 bg-indigo-600 text-sm font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 sm:w-auto transition-all">
                        Schedule Class
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
                <h3 class="text-2xl font-extrabold text-slate-900 mb-3">Cancel Class?</h3>
                <p class="text-slate-500 font-medium px-4">Are you sure you want to remove <span id="delete-class-name" class="text-slate-900 font-bold underline decoration-red-200 decoration-4"></span>? This action cannot be reversed.</p>
            </div>
            <div class="bg-slate-50 px-6 py-6 border-t border-slate-100 flex flex-col sm:flex-row-reverse gap-3">
                <form id="delete-form" action="" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-3 bg-red-600 text-sm font-bold text-white hover:bg-red-700 shadow-xl shadow-red-600/20 transition-all">
                        Yes, Cancel Class
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-200 px-6 py-3 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    No, Keep Class
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('class-modal');
    const form = document.getElementById('class-form');
    const methodDiv = document.getElementById('form-method');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');
    
    function openAddModal() {
        title.innerText = "Schedule New Class";
        submitBtn.innerText = "Schedule Class";
        form.action = "{{ route('classes.store') }}";
        methodDiv.innerHTML = "";
        
        document.getElementById('class_name').value = '';
        document.getElementById('class_room').value = '';
        document.getElementById('class_date').value = '{{ $date ?? \Carbon\Carbon::today()->toDateString() }}';
        
        // Reset times
        document.getElementById('class_start_time').value = '09:00';
        document.getElementById('class_end_time').value = '10:00';
        document.getElementById('class_capacity').value = 20;
        
        // Select first trainer
        const trainerSelect = document.getElementById('class_trainer_id');
        if(trainerSelect.options.length > 0) trainerSelect.selectedIndex = 0;

        // Reset color to indigo
        document.querySelector('input[name="color_theme"][value="indigo"]').checked = true;
        
        modal.classList.remove('hidden');
    }

    function openEditModal(gymClass) {
        title.innerText = "Update Class Schedule";
        submitBtn.innerText = "Save Changes";
        form.action = `/classes/${gymClass.id}`;
        methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('class_name').value = gymClass.name;
        document.getElementById('class_trainer_id').value = gymClass.trainer_id;
        document.getElementById('class_room').value = gymClass.room;
        if(gymClass.class_date) {
            document.getElementById('class_date').value = gymClass.class_date.substring(0, 10);
        }
        
        // Format time properly to H:i for HTML5 time input
        let start = gymClass.start_time.substring(0, 5);
        let end = gymClass.end_time.substring(0, 5);
        
        document.getElementById('class_start_time').value = start;
        document.getElementById('class_end_time').value = end;
        document.getElementById('class_capacity').value = gymClass.capacity;
        
        // Check corresponding color radio
        const colorRadio = document.querySelector(`input[name="color_theme"][value="${gymClass.color_theme}"]`);
        if(colorRadio) colorRadio.checked = true;
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-class-name').innerText = name;
        document.getElementById('delete-form').action = `/classes/${id}`;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>

@endsection
