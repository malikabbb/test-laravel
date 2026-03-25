<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Trainer;
use App\Models\GymClass;
use App\Models\Payment;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');

        if (empty($query)) {
            return view('search', [
                'query' => '',
                'members' => collect(),
                'trainers' => collect(),
                'classes' => collect(),
                'payments' => collect(),
            ]);
        }

        $members = Member::where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->take(10)->get();

        $trainers = Trainer::where('name', 'like', "%{$query}%")
            ->orWhere('role', 'like', "%{$query}%")
            ->take(10)->get();

        $classes = GymClass::with('trainer')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('room', 'like', "%{$query}%")
            ->take(10)->get();

        $payments = Payment::with('member')
            ->where('plan_name', 'like', "%{$query}%")
            ->orWhere('method', 'like', "%{$query}%")
            ->take(10)->get();

        return view('search', compact('query', 'members', 'trainers', 'classes', 'payments'));
    }
}
