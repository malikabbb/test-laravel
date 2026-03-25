<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Http\Requests\StoreTrainerRequest;
use App\Http\Requests\UpdateTrainerRequest;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        $search = $request->get('search');
        
        $query = Trainer::query();

        if ($role) {
            $query->where('role', 'like', "%$role%");
        }
        
        if ($search) {
            $query->where('name', 'like', "%$search%");
        }

        $trainers = $query->orderBy('id', 'desc')->paginate(12);

        return view('trainers', compact('trainers', 'role'));
    }

    public function store(StoreTrainerRequest $request)
    {
        Trainer::create($request->validated());
        return redirect()->route('trainers.index')->with('success', 'Trainer onboarded successfully.');
    }

    public function update(UpdateTrainerRequest $request, Trainer $trainer)
    {
        $trainer->update($request->validated());
        return redirect()->route('trainers.index')->with('success', 'Trainer profile updated.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('trainers.index')->with('success', 'Trainer record removed.');
    }
}
