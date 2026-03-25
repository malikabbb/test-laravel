<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use App\Http\Requests\StoreGymClassRequest;
use App\Http\Requests\UpdateGymClassRequest;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    public function index()
    {
        $classes = GymClass::with('trainer')->orderBy('start_time')->get();
        return response()->json($classes);
    }

    public function store(StoreGymClassRequest $request)
    {
        $class = GymClass::create($request->validated());
        return response()->json(['message' => 'Class created successfully.', 'class' => $class], 201);
    }

    public function show(GymClass $class)
    {
        $class->load('trainer');
        return response()->json($class);
    }

    public function update(UpdateGymClassRequest $request, GymClass $class)
    {
        $class->update($request->validated());
        return response()->json(['message' => 'Class updated successfully.', 'class' => $class]);
    }

    public function destroy(GymClass $class)
    {
        $class->delete();
        return response()->json(['message' => 'Class deleted successfully.']);
    }
}
