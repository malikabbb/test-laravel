@extends('layouts.dashboard')

@section('title', 'Search Results')
@section('header_title', 'Search Results')
@section('header_subtitle')
    @if($query)
        Showing results for "<strong>{{ $query }}</strong>"
    @else
        Enter a search term to find members, trainers, classes, or payments.
    @endif
@endsection

@section('content')

@if(empty($query))
<div class="py-20 text-center">
    <svg class="w-20 h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    <p class="text-xl font-bold text-slate-500">Type something in the search bar above</p>
</div>
@else

@php
    $totalResults = $members->count() + $trainers->count() + $classes->count() + $payments->count();
@endphp

@if($totalResults === 0)
<div class="py-20 text-center">
    <svg class="w-20 h-20 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    <p class="text-xl font-bold text-slate-500">No results found for "{{ $query }}"</p>
    <p class="text-sm text-slate-400 mt-2">Try a different search term.</p>
</div>
@else
<p class="text-sm font-bold text-slate-400 mb-6 uppercase tracking-wider">{{ $totalResults }} result{{ $totalResults > 1 ? 's' : '' }} found</p>
@endif

{{-- Members Results --}}
@if($members->count() > 0)
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-extrabold text-lg text-slate-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Members <span class="ml-2 text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">{{ $members->count() }}</span>
        </h3>
        <a href="{{ route('members.index', ['search' => $query]) }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">View All →</a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($members as $member)
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('members.index') }}'">
                    <td class="px-6 py-4 flex items-center">
                        <img class="w-9 h-9 rounded-xl border-2 border-white shadow-sm mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f1f5f9" alt="">
                        <div>
                            <p class="font-bold text-slate-800">{{ $member->name }}</p>
                            <p class="text-xs text-slate-400">{{ $member->email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-600">{{ $member->plan_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $member->status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $member->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Trainers Results --}}
@if($trainers->count() > 0)
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-extrabold text-lg text-slate-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            Trainers <span class="ml-2 text-xs bg-sky-100 text-sky-600 px-2 py-0.5 rounded-full">{{ $trainers->count() }}</span>
        </h3>
        <a href="{{ route('trainers.index') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">View All →</a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($trainers as $trainer)
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('trainers.index') }}'">
                    <td class="px-6 py-4 flex items-center">
                        <img class="w-9 h-9 rounded-xl border-2 border-white shadow-sm mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($trainer->name) }}&background=e0f2fe" alt="">
                        <p class="font-bold text-slate-800">{{ $trainer->name }}</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-600">{{ $trainer->role }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $trainer->status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ $trainer->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Classes Results --}}
@if($classes->count() > 0)
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-extrabold text-lg text-slate-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            Classes <span class="ml-2 text-xs bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full">{{ $classes->count() }}</span>
        </h3>
        <a href="{{ route('classes.index') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">View All →</a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($classes as $class)
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('classes.index') }}'">
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $class->name }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $class->room }}</td>
                    <td class="px-6 py-4 text-slate-500">{{ $class->trainer->name ?? 'Unassigned' }}</td>
                    <td class="px-6 py-4 text-slate-400 text-xs font-bold">{{ \Carbon\Carbon::parse($class->start_time)->format('h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Payments Results --}}
@if($payments->count() > 0)
<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="font-extrabold text-lg text-slate-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Payments <span class="ml-2 text-xs bg-emerald-100 text-emerald-600 px-2 py-0.5 rounded-full">{{ $payments->count() }}</span>
        </h3>
        <a href="{{ route('payments.index') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors">View All →</a>
    </div>
    <div class="bg-white rounded-2xl shadow-lg shadow-slate-200/40 border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($payments as $pay)
                <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="window.location='{{ route('payments.index') }}'">
                    <td class="px-6 py-4 font-bold text-slate-800">{{ $pay->member->name ?? 'Unknown' }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $pay->plan_name }}</td>
                    <td class="px-6 py-4 font-extrabold text-slate-900">${{ number_format($pay->amount, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $pay->status === 'Paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $pay->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endif
@endsection
