<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use App\Models\Trainer;
use App\Http\Requests\StoreGymClassRequest;
use App\Http\Requests\UpdateGymClassRequest;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', \Carbon\Carbon::today()->toDateString());
        
        $classes = GymClass::with('trainer')
            ->whereDate('class_date', $date)
            ->orderBy('start_time')
            ->get();
            
        $trainers = Trainer::all();
        
        return view('classes', compact('classes', 'trainers', 'date'));
    }

    public function store(StoreGymClassRequest $request)
    {
        GymClass::create($request->validated());
        return redirect()->route('classes.index')->with('success', 'Class scheduled successfully.');
    }

    public function update(UpdateGymClassRequest $request, GymClass $class)
    {
        $class->update($request->validated());
        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    public function destroy(GymClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class removed from schedule.');
    }
}
