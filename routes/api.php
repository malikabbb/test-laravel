<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MemberController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/create-admin', [AuthController::class, 'createAdmin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('members', MemberController::class)->names([
        'index' => 'api.members.index',
        'store' => 'api.members.store',
        'show' => 'api.members.show',
        'update' => 'api.members.update',
        'destroy' => 'api.members.destroy',
    ]);

    Route::apiResource('trainers', \App\Http\Controllers\Api\TrainerController::class)->names([
        'index' => 'api.trainers.index',
        'store' => 'api.trainers.store',
        'show' => 'api.trainers.show',
        'update' => 'api.trainers.update',
        'destroy' => 'api.trainers.destroy',
    ]);

    Route::apiResource('classes', \App\Http\Controllers\Api\GymClassController::class)->names([
        'index' => 'api.classes.index',
        'store' => 'api.classes.store',
        'show' => 'api.classes.show',
        'update' => 'api.classes.update',
        'destroy' => 'api.classes.destroy',
    ]);

    Route::apiResource('payments', \App\Http\Controllers\Api\PaymentController::class)->names([
        'index' => 'api.payments.index',
        'store' => 'api.payments.store',
        'show' => 'api.payments.show',
        'update' => 'api.payments.update',
        'destroy' => 'api.payments.destroy',
    ]);
});
