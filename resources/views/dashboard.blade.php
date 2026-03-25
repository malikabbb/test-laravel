@extends('layouts.dashboard')

@section('title', 'Overview')
@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Here is what is happening at your gym today.')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-100 flex justify-between items-center group relative overflow-hidden transition-all hover:shadow-2xl hover:shadow-orange-500/10">
        <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-orange-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Total Members</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($totalMembers) }}</h3>
            <p class="text-xs font-bold text-emerald-500 mt-2 flex items-center bg-emerald-50 w-max px-2 py-0.5 rounded-full">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                12.5% this month
            </p>
        </div>
        <div class="w-14 h-14 bg-gradient-to-tr from-orange-50 to-orange-100/50 rounded-2xl flex items-center justify-center text-orange-500 shadow-sm group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-100 flex justify-between items-center group relative overflow-hidden transition-all hover:shadow-2xl hover:shadow-orange-500/10">
        <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-orange-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Active Trainers</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($activeTrainers) }}</h3>
            <p class="text-xs font-bold text-slate-500 mt-2 flex items-center bg-slate-50 w-max px-2 py-0.5 rounded-full">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                Same as last week
            </p>
        </div>
        <div class="w-14 h-14 bg-gradient-to-tr from-sky-50 to-sky-100/50 rounded-2xl flex items-center justify-center text-sky-500 shadow-sm group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-100 flex justify-between items-center group relative overflow-hidden transition-all hover:shadow-2xl hover:shadow-orange-500/10">
        <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-orange-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Scheduled Classes</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">{{ number_format($scheduledClasses) }}</h3>
            <p class="text-xs font-bold text-indigo-500 mt-2 flex items-center bg-indigo-50 w-max px-2 py-0.5 rounded-full">
                Today
            </p>
        </div>
        <div class="w-14 h-14 bg-gradient-to-tr from-indigo-50 to-indigo-100/50 rounded-2xl flex items-center justify-center text-indigo-500 shadow-sm group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-100 flex justify-between items-center group relative overflow-hidden transition-all hover:shadow-2xl hover:shadow-orange-500/10">
        <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-orange-400 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div>
            <p class="text-sm font-semibold text-slate-500">Monthly Revenue</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tracking-tight">${{ $monthlyRevenue >= 1000 ? number_format($monthlyRevenue / 1000, 1) . 'k' : number_format($monthlyRevenue, 2) }}</h3>
            <p class="text-xs font-bold text-emerald-500 mt-2 flex items-center bg-emerald-50 w-max px-2 py-0.5 rounded-full">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                8.2% vs last month
            </p>
        </div>
        <div class="w-14 h-14 bg-gradient-to-tr from-emerald-50 to-emerald-100/50 rounded-2xl flex items-center justify-center text-emerald-500 shadow-sm group-hover:scale-110 transition-transform">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>
</div>

<!-- Content Split layout -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Left Span (2 cols): Recent Activities Table -->
    <div class="lg:col-span-2 bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white/50 backdrop-blur-sm">
            <h3 class="font-extrabold text-lg text-slate-900 tracking-tight">Recent Registrations</h3>
            <a href="{{ route('members.index') }}" class="text-sm font-bold text-orange-500 hover:text-orange-600 transition-colors bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-xl">View All</a>
        </div>
        <div class="flex-1 overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Plan</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($recentRegistrations as $member)
                    <tr class="hover:bg-slate-50 transition-colors group cursor-pointer" onclick="window.location='{{ route('members.index') }}'">
                        <td class="px-6 py-4 flex items-center">
                            <img class="w-10 h-10 rounded-xl border-2 border-white shadow-sm mr-4" src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=f1f5f9" alt="Avatar">
                            <div>
                                <p class="font-bold text-slate-800 group-hover:text-orange-500 transition-colors">{{ $member->name }}</p>
                                <p class="text-xs font-medium text-slate-400">{{ $member->email }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4"><span class="font-bold text-slate-700">{{ $member->plan_name ?? 'N/A' }}</span></td>
                        <td class="px-6 py-4">
                            @if($member->status == 'Active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Active</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">{{ $member->status }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 font-medium">{{ $member->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-bold">No recent registrations.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right Span (1 col): Upcoming Classes -->
    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white/50 backdrop-blur-sm">
            <h3 class="font-extrabold text-lg text-slate-900 tracking-tight">Today's Schema</h3>
            <a href="{{ route('classes.index') }}" class="text-orange-500 hover:text-orange-600 bg-orange-50 p-2 rounded-xl transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg></a>
        </div>
        <div class="p-6 space-y-6 flex-1">
            @forelse($upcomingClasses as $class)
            <div class="flex items-start group cursor-pointer" onclick="window.location='{{ route('classes.index') }}'">
                <div class="w-14 h-14 bg-{{ $class->color_theme ?? 'orange' }}-50 group-hover:bg-{{ $class->color_theme ?? 'orange' }}-500 group-hover:shadow-lg group-hover:shadow-{{ $class->color_theme ?? 'orange' }}-500/30 transition-all rounded-2xl flex flex-col items-center justify-center text-{{ $class->color_theme ?? 'orange' }}-600 group-hover:text-white shrink-0 border border-{{ $class->color_theme ?? 'orange' }}-100 group-hover:border-{{ $class->color_theme ?? 'orange' }}-500">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider">{{ \Carbon\Carbon::parse($class->start_time)->format('A') }}</span>
                    <span class="text-sm font-extrabold leading-none">{{ \Carbon\Carbon::parse($class->start_time)->format('h:i') }}</span>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-bold text-slate-900 group-hover:text-orange-500 transition-colors">{{ $class->name }}</h4>
                    <p class="text-xs font-medium text-slate-500 mt-1 flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $class->room ?? 'No room' }}
                    </p>
                    <p class="text-xs text-orange-500 font-bold mt-1">{{ $class->trainer->name ?? 'Unassigned' }}</p>
                </div>
            </div>
            @empty
            <div class="text-center text-slate-500 font-bold py-8">No upcoming classes.</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Fake Chart Graphic Section -->
<div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100 p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h3 class="font-extrabold text-xl text-slate-900 tracking-tight">Revenue Analytics</h3>
            <p class="text-sm font-medium text-slate-500">Net revenue growth across months</p>
        </div>
        <select class="text-sm font-bold border-slate-200 rounded-xl text-slate-700 focus:ring-orange-500 focus:border-orange-500 bg-slate-50 py-2.5 pl-4 pr-10 hover:bg-slate-100 cursor-pointer transition-colors outline-none shadow-sm">
            <option>This Year</option>
            <option>Last 6 Months</option>
        </select>
    </div>
    <div class="h-72 w-full bg-slate-50/50 rounded-2xl relative flex items-end justify-between px-2 sm:px-8 pt-10 pb-4 border-b-2 border-slate-200">
        <!-- Chart Bars -->
        @foreach($chartData as $index => $data)
            @php 
                $heightStr = $data['height'] . '%';
            @endphp
            @if($index == 5)
                <div class="w-[8%] bg-gradient-to-t from-orange-500 to-orange-400 rounded-t-xl rounded-b-sm hover:scale-x-110 hover:-translate-y-1 transition-all relative group cursor-pointer shadow-xl shadow-orange-500/30 ring-2 ring-white" style="height: {{ $heightStr }};">
                    <span class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white tracking-wide font-extrabold text-xs py-1.5 px-3 rounded-xl opacity-0 group-hover:opacity-100 pointer-events-none shadow-xl whitespace-nowrap">${{ $data['revenueK'] }}</span>
                </div>
            @else
                <div class="w-[8%] bg-gradient-to-t from-slate-300 to-slate-200 rounded-lg hover:scale-x-110 hover:-translate-y-1 transition-all relative group cursor-pointer shadow-sm" style="height: {{ $heightStr }};">
                    <span class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-slate-800 text-white font-bold text-xs py-1.5 px-2.5 rounded-lg opacity-0 group-hover:opacity-100 pointer-events-none shadow-lg whitespace-nowrap">${{ $data['revenueK'] }}</span>
                </div>
            @endif
        @endforeach
        
        <!-- X Axis Labels mock -->
        <div class="absolute -bottom-8 left-0 w-full flex justify-between px-4 sm:px-10 text-xs font-extrabold text-slate-400 uppercase tracking-widest">
            @foreach($chartData as $index => $data)
                @if($index == 5)
                    <span class="text-orange-500 bg-orange-50 px-2 py-0.5 rounded-md">{{ $data['month'] }}</span>
                @else
                    <span>{{ $data['month'] }}</span>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection
