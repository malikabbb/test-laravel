<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\GymClass;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Key Metrics
        $totalMembers = Member::count();
        $activeTrainers = Trainer::where('status', 'Active')->count();
        $scheduledClasses = GymClass::whereDate('class_date', $today)->count();
        
        $monthlyRevenue = Payment::where('status', 'Paid')
            ->whereMonth('payment_date', $today->month)
            ->whereYear('payment_date', $today->year)
            ->sum('amount');
            
        // Recent Activities
        $recentRegistrations = Member::orderBy('created_at', 'desc')->take(4)->get();
        
        $upcomingClasses = GymClass::with('trainer')
            ->whereDate('class_date', '>=', $today)
            ->orderBy('class_date')
            ->orderBy('start_time')
            ->take(3)
            ->get();
            
        // Revenue Chart (Last 6 Months logic roughly simplified)
        // We will generate 6 dummy heights for visual purposes based on the max revenue
        // representing months -5 to 0.
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Payment::where('status', 'Paid')
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->sum('amount');
            
            $chartData[] = [
                'month' => $month->format('M'),
                'revenue' => $revenue,
                'revenueK' => number_format($revenue / 1000, 1) . 'k'
            ];
        }
        
        $maxRevenue = collect($chartData)->max('revenue');
        $maxRevenue = $maxRevenue == 0 ? 1 : $maxRevenue; // Prevent division by zero
        
        foreach ($chartData as &$data) {
            $data['height'] = min(max(($data['revenue'] / $maxRevenue) * 95, 20), 95); // Between 20% and 95%
        }

        return view('dashboard', compact(
            'totalMembers', 
            'activeTrainers', 
            'scheduledClasses', 
            'monthlyRevenue',
            'recentRegistrations',
            'upcomingClasses',
            'chartData'
        ));
    }
}
