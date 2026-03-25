<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Http\Requests\StoreTrainerRequest;
use App\Http\Requests\UpdateTrainerRequest;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        
        $query = Trainer::query();

        if ($role) {
            $query->where('role', 'like', "%$role%");
        }

        return response()->json($query->orderBy('id', 'desc')->paginate(15));
    }

    public function store(StoreTrainerRequest $request)
    {
        $trainer = Trainer::create($request->validated());
        return response()->json(['message' => 'Trainer created successfully.', 'trainer' => $trainer], 201);
    }

    public function show(Trainer $trainer)
    {
        return response()->json($trainer);
    }

    public function update(UpdateTrainerRequest $request, Trainer $trainer)
    {
        $trainer->update($request->validated());
        return response()->json(['message' => 'Trainer updated successfully.', 'trainer' => $trainer]);
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return response()->json(['message' => 'Trainer deleted successfully.']);
    }
}
