@extends('layouts.dashboard')

@section('title', 'Members')
@section('header_title', 'Members Directory')
@section('header_subtitle', 'Manage your gym members, memberships, and activity.')

@section('header_actions')
<button onclick="openAddModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all hover:scale-105 flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
    Add Member
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

<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden flex flex-col">
    <!-- Filter Bar -->
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
        <div class="flex space-x-2 w-full sm:w-auto overflow-x-auto pb-2 sm:pb-0">
            <a href="{{ route('members.index') }}" class="px-4 py-2 {{ !$status ? 'bg-orange-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }} text-sm font-bold rounded-xl shadow-md transition-all whitespace-nowrap">All Members</a>
            <a href="{{ route('members.index', ['status' => 'Active']) }}" class="px-4 py-2 {{ $status == 'Active' ? 'bg-emerald-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }} text-sm font-bold rounded-xl shadow-md transition-all whitespace-nowrap">Active</a>
            <a href="{{ route('members.index', ['status' => 'Pending']) }}" class="px-4 py-2 {{ $status == 'Pending' ? 'bg-amber-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }} text-sm font-bold rounded-xl shadow-md transition-all whitespace-nowrap">Pending</a>
            <a href="{{ route('members.index', ['status' => 'Expired']) }}" class="px-4 py-2 {{ $status == 'Expired' ? 'bg-red-500 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }} text-sm font-bold rounded-xl shadow-md transition-all whitespace-nowrap">Expired</a>
        </div>
        <div class="flex w-full sm:w-auto space-x-3">
            <form action="{{ route('members.index') }}" method="GET" class="relative w-full">
                @if($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all font-medium">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-white border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Member Info</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Plan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($members as $member)
                <tr class="hover:bg-slate-50 transition-colors group">
                    <td class="px-6 py-4 font-bold text-slate-400">#{{ $member->id }}</td>
                    <td class="px-6 py-4 flex items-center">
                        <img class="w-10 h-10 rounded-xl border-2 border-white shadow-sm mr-4" src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f1f5f9" alt="Avatar">
                        <div>
                            <p class="font-bold text-slate-800 group-hover:text-orange-500 transition-colors">{{ $member->name }}</p>
                            <p class="text-xs font-medium text-slate-500">{{ $member->email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="font-bold text-slate-700">{{ $member->plan_name }}</span></td>
                    <td class="px-6 py-4">
                        @php
                            $colors = match($member->status) {
                                'Active' => 'bg-emerald-100 text-emerald-700',
                                'Pending' => 'bg-amber-100 text-amber-700',
                                'Expired' => 'bg-red-100 text-red-700',
                                default => 'bg-slate-100 text-slate-700'
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $colors }}">
                            {{ $member->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button onclick="openEditModal({{ json_encode($member) }})" class="text-slate-400 hover:text-indigo-500 transition-colors p-2 bg-slate-50 hover:bg-white rounded-xl border border-transparent hover:border-slate-100 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        
                        <button onclick="openDeleteModal({{ $member->id }}, '{{ addslashes($member->name) }}')" class="text-slate-400 hover:text-red-500 transition-colors p-2 bg-slate-50 hover:bg-white rounded-xl border border-transparent hover:border-slate-100 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <p class="text-lg font-bold text-slate-500">No members found</p>
                        <p class="text-sm">Try adjusting your filters or add a new member.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($members->hasPages())
    <div class="p-6 border-t border-slate-100 bg-slate-50/30">
        {{ $members->appends(['status' => $status])->links() }}
    </div>
    @endif
</div>

<!-- Add/Edit Modal Container -->
<div id="member-modal" class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full border border-slate-100">
            <form id="member-form" action="{{ route('members.store') }}" method="POST">
                @csrf
                <div id="form-method"></div>
                
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-orange-100 sm:mx-0 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="modal-title">Register Member</h3>
                            <div class="mt-6 space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Full Name</label>
                                    <input type="text" name="name" id="member_name" value="{{ old('name') }}" placeholder="John Doe" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('name') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                    @error('name') <p class="mt-1.5 text-xs font-bold text-red-500 flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Email Address</label>
                                    <input type="email" name="email" id="member_email" value="{{ old('email') }}" placeholder="john@example.com" required class="w-full px-4 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-300 ring-4 ring-red-500/10' : 'border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10' }} bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                    @error('email') <p class="mt-1.5 text-xs font-bold text-red-500 flex items-center"><svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $message }}</p> @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Phone</label>
                                        <input type="text" name="phone" id="member_phone" value="{{ old('phone') }}" placeholder="+1 (555) 000" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Status</label>
                                        <select name="status" id="member_status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 bg-slate-50 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                            <option value="Active">🟢 Active</option>
                                            <option value="Pending">🟠 Pending</option>
                                            <option value="Expired">🔴 Expired</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Membership Plan</label>
                                    <select name="plan_name" id="member_plan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 bg-slate-50 focus:bg-white transition-all outline-none font-bold text-slate-700">
                                        <option value="Basic Monthly">Basic Monthly ($29/mo)</option>
                                        <option value="Pro Monthly">Pro Monthly ($49/mo)</option>
                                        <option value="Elite Annual">Elite Annual ($499/yr)</option>
                                        <option value="Weekly Visitor">Weekly Visitor ($15/wk)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-6 sm:flex sm:flex-row-reverse rounded-b-3xl border-t border-slate-100 gap-3">
                    <button type="submit" id="submit-btn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-xl shadow-orange-500/20 px-6 py-3 bg-orange-500 text-sm font-bold text-white hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-500/20 sm:w-auto transition-all">
                        Register Member
                    </button>
                    <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-200 shadow-sm px-6 py-3 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-all">
                        Cancel navigation
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
                <h3 class="text-2xl font-extrabold text-slate-900 mb-3">Terminate Membership?</h3>
                <p class="text-slate-500 font-medium px-4">Are you sure you want to remove <span id="delete-member-name" class="text-slate-900 font-bold underline decoration-red-200 decoration-4"></span> from the directory? This action cannot be reversed.</p>
            </div>
            <div class="bg-slate-50 px-6 py-6 border-t border-slate-100 flex flex-col sm:flex-row-reverse gap-3">
                <form id="delete-form" action="" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-3 bg-red-600 text-sm font-bold text-white hover:bg-red-700 shadow-xl shadow-red-600/20 transition-all">
                        Yes, Delete Member
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-200 px-6 py-3 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    No, Keep Member
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('member-modal');
    const form = document.getElementById('member-form');
    const methodDiv = document.getElementById('form-method');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');
    
    function openAddModal() {
        title.innerText = "Register New Member";
        submitBtn.innerText = "Register Member";
        form.action = "{{ route('members.store') }}";
        methodDiv.innerHTML = "";
        
        // Clear fields
        ['name', 'email', 'phone', 'plan', 'status'].forEach(id => {
            const el = document.getElementById('member_' + id);
            if (el) el.value = '';
        });
        
        modal.classList.remove('hidden');
    }

    function openEditModal(member) {
        title.innerText = "Update Member Record";
        submitBtn.innerText = "Modernize Details";
        form.action = `/members/${member.id}`;
        methodDiv.innerHTML = '@method("PUT")';
        
        document.getElementById('member_name').value = member.name;
        document.getElementById('member_email').value = member.email;
        document.getElementById('member_phone').value = member.phone || '';
        document.getElementById('member_status').value = member.status;
        document.getElementById('member_plan').value = member.plan_name;
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-member-name').innerText = name;
        document.getElementById('delete-form').action = `/members/${id}`;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>

@endsection
