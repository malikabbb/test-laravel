<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('member')->orderBy('payment_date', 'desc')->get();
        return response()->json($payments);
    }

    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return response()->json(['message' => 'Payment created successfully.', 'payment' => $payment], 201);
    }

    public function show(Payment $payment)
    {
        $payment->load('member');
        return response()->json($payment);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return response()->json(['message' => 'Payment updated successfully.', 'payment' => $payment]);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully.']);
    }
}
