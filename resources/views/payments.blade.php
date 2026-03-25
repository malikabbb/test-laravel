@extends('layouts.dashboard')

@section('title', 'Payments')
@section('header_title', 'Manual Payment Processing')
@section('header_subtitle', 'Record Cash/POS payments and generate member receipts.')

@section('header_actions')
<button onclick="openAddModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all hover:scale-105 flex items-center">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
    Record Payment
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

<!-- Payment Processing Highlights -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-6 shadow-xl shadow-slate-900/20 text-white relative overflow-hidden group">
        <svg class="absolute -right-4 -bottom-4 w-32 h-32 text-slate-700/30 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
        <p class="text-slate-400 font-bold text-sm uppercase tracking-wider">Today's Manual Collections</p>
        <h3 class="text-4xl font-extrabold mt-2 tracking-tight">${{ number_format($todayCollections ?? 0, 2) }}</h3>
        <p class="text-sm font-bold mt-4 flex items-center bg-slate-700/50 w-max px-3 py-1 rounded-full backdrop-blur-sm">
            <svg class="w-4 h-4 mr-1 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ $todayTransactions ?? 0 }} Payments Secured Today
        </p>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-100 relative group overflow-hidden">
        <div class="absolute right-0 top-0 h-full w-1.5 bg-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <p class="text-slate-500 font-bold text-sm uppercase tracking-wider">Awaiting Desk Payment</p>
        <h3 class="text-4xl font-extrabold mt-2 text-slate-800 tracking-tight">{{ $awaitingPayment ?? 0 }}</h3>
        <p class="text-sm font-bold mt-4 flex items-center text-orange-600 bg-orange-50 w-max px-3 py-1 rounded-full border border-orange-100">
            <svg class="w-4 h-4 mr-1 pb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Members Pending Action
        </p>
    </div>
</div>

<!-- Payment Processing Table -->
<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden flex flex-col">
    <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/50">
        <div>
            <h3 class="font-extrabold text-lg text-slate-900 tracking-tight">Desk Payment Log</h3>
            <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-widest">Verify and print receipts for manual payments</p>
        </div>
        <div class="flex space-x-2">
            <form action="{{ route('payments.index') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/10 font-bold transition-all" placeholder="Search member...">
                <button type="submit" class="absolute inset-y-0 left-0 pl-3 flex items-center">
                    <svg class="w-4 h-4 text-slate-400 hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>
            </form>
        </div>
    </div>
    <div class="flex-1 overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Member</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Plan</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse($payments as $pay)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 font-extrabold text-slate-900">{{ $pay->member->name ?? 'Unknown' }}</td>
                    <td class="px-6 py-4 font-bold text-slate-600">{{ $pay->plan_name }}</td>
                    <td class="px-6 py-4 font-extrabold text-slate-900">${{ number_format($pay->amount, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-lg bg-slate-100 text-slate-600 font-extrabold text-[10px] uppercase">
                            {{ $pay->method }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($pay->status === 'Paid')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-emerald-100 text-emerald-700 border border-emerald-200">
                            {{ $pay->status }}
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-100 text-amber-700 border border-amber-200">
                            {{ $pay->status }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-500 font-bold">{{ \Carbon\Carbon::parse($pay->payment_date)->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-right flex justify-end space-x-2">
                        @if($pay->status === 'Paid')
                        <a href="{{ route('receipt', ['member' => $pay->member->name ?? 'User', 'plan' => $pay->plan_name, 'price' => '$'.number_format($pay->amount, 2), 'method' => $pay->method, 'date' => \Carbon\Carbon::parse($pay->payment_date)->format('M d, Y')]) }}" target="_blank" class="text-emerald-600 hover:text-white hover:bg-emerald-500 border border-emerald-200 hover:border-emerald-500 px-3 py-1.5 rounded-xl font-extrabold text-xs transition-all shadow-sm flex items-center justify-center bg-white">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print Receipt
                        </a>
                        @endif
                        
                        <button onclick='openEditModal(@json($pay))' class="text-indigo-500 hover:bg-indigo-50 border border-indigo-100 px-3 py-1.5 rounded-xl font-extrabold text-xs transition-all shadow-sm bg-white">
                            Edit
                        </button>
                        <button onclick="openDeleteModal({{ $pay->id }})" class="text-red-500 hover:bg-red-50 border border-red-100 px-3 py-1.5 rounded-xl font-extrabold text-xs transition-all shadow-sm bg-white">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-500 font-bold">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
        {{ $payments->links() }}
    </div>
    @endif
</div>

<!-- Add/Edit Modal Container -->
<div id="payment-modal" class="{{ (isset($errors) && $errors->any()) ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-100">
            <form id="payment-form" action="{{ route('payments.store') }}" method="POST">
                @csrf
                <div id="form-method"></div>
                
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-2xl bg-orange-100 sm:mx-0 sm:h-12 sm:w-12">
                            <svg class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight" id="modal-title">Record Payment</h3>
                            <div class="mt-6 space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Member</label>
                                    <select name="member_id" id="payment_member_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('member_id') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Plan Name</label>
                                    <select name="plan_name" id="payment_plan_name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                        <option value="Basic Access" {{ old('plan_name') == 'Basic Access' ? 'selected' : '' }}>Basic Access</option>
                                        <option value="Pro Membership" {{ old('plan_name') == 'Pro Membership' ? 'selected' : '' }}>Pro Membership</option>
                                        <option value="Elite Athlete" {{ old('plan_name') == 'Elite Athlete' ? 'selected' : '' }}>Elite Athlete</option>
                                        <option value="Yoga Plus" {{ old('plan_name') == 'Yoga Plus' ? 'selected' : '' }}>Yoga Plus</option>
                                    </select>
                                    @error('plan_name') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Amount ($)</label>
                                        <input type="number" step="0.01" name="amount" id="payment_amount" value="{{ old('amount') }}" placeholder="120.00" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white transition-all outline-none font-medium text-slate-900">
                                        @error('amount') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Date</label>
                                        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', \Carbon\Carbon::now()->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white transition-all outline-none font-medium text-slate-900">
                                        @error('payment_date') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Method</label>
                                        <select name="method" id="payment_method" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                            <option value="Cash" {{ old('method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="POS" {{ old('method') == 'POS' ? 'selected' : '' }}>POS Tracker</option>
                                            <option value="Other" {{ old('method') == 'Other' ? 'selected' : '' }}>Other / Checks</option>
                                            <option value="-" {{ old('method') == '-' ? 'selected' : '' }}>- (Awaiting)</option>
                                        </select>
                                        @error('method') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Status</label>
                                        <select name="status" id="payment_status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white transition-all outline-none font-medium">
                                            <option value="Paid" {{ old('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                        @error('status') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 px-6 py-6 sm:flex sm:flex-row-reverse rounded-b-3xl border-t border-slate-100 gap-3">
                    <button type="submit" id="submit-btn" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-xl shadow-orange-500/20 px-6 py-3 bg-orange-500 text-sm font-bold text-white hover:bg-orange-600 focus:outline-none focus:ring-4 focus:ring-orange-500/20 sm:w-auto transition-all">
                        Record Payment
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
                <h3 class="text-2xl font-extrabold text-slate-900 mb-3">Delete Record?</h3>
                <p class="text-slate-500 font-medium px-4">Are you sure you want to permanently erase this transaction record? This action cannot be reversed.</p>
            </div>
            <div class="bg-slate-50 px-6 py-6 border-t border-slate-100 flex flex-col sm:flex-row-reverse gap-3">
                <form id="delete-form" action="" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent px-6 py-3 bg-red-600 text-sm font-bold text-white hover:bg-red-700 shadow-xl shadow-red-600/20 transition-all">
                        Delete Permanently
                    </button>
                </form>
                <button type="button" onclick="closeDeleteModal()" class="w-full inline-flex justify-center rounded-xl border border-slate-200 px-6 py-3 bg-white text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('payment-modal');
    const form = document.getElementById('payment-form');
    const methodDiv = document.getElementById('form-method');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');
    
    function openAddModal() {
        title.innerText = "Record Payment";
        submitBtn.innerText = "Record Payment";
        form.action = "{{ route('payments.store') }}";
        methodDiv.innerHTML = "";
        
        document.getElementById('payment_amount').value = '';
        
        // Defaults
        const memberSelect = document.getElementById('payment_member_id');
        if(memberSelect.options.length > 0) memberSelect.selectedIndex = 0;
        document.getElementById('payment_plan_name').value = 'Pro Membership';
        document.getElementById('payment_method').value = 'Cash';
        document.getElementById('payment_status').value = 'Paid';
        
        modal.classList.remove('hidden');
    }

    function openEditModal(payment) {
        title.innerText = "Update Payment Log";
        submitBtn.innerText = "Save Changes";
        form.action = `/payments/${payment.id}`;
        methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        
        document.getElementById('payment_member_id').value = payment.member_id;
        document.getElementById('payment_plan_name').value = payment.plan_name;
        document.getElementById('payment_amount').value = payment.amount;
        document.getElementById('payment_method').value = payment.method;
        document.getElementById('payment_status').value = payment.status;
        
        // Format date properly for HTML5 date input
        if (payment.payment_date) {
            let pureDate = payment.payment_date.split('T')[0];
            document.getElementById('payment_date').value = pureDate;
        }
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function openDeleteModal(id) {
        document.getElementById('delete-form').action = `/payments/${id}`;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>

@endsection
