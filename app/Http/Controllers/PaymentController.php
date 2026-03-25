<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('member')->orderBy('payment_date', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('member', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $payments = $query->paginate(15)->withQueryString();
        $members = Member::all(); // For the 'Record Payment' dropdown

        // Compute Highlights
        $today = Carbon::today();
        
        $todayCollections = Payment::where('status', 'Paid')
            ->whereDate('payment_date', $today)
            ->sum('amount');
            
        $todayTransactions = Payment::where('status', 'Paid')
            ->whereDate('payment_date', $today)
            ->count();
            
        $awaitingPayment = Payment::where('status', 'Pending')->count();

        return view('payments', compact(
            'payments', 'members', 'todayCollections', 'todayTransactions', 'awaitingPayment'
        ));
    }

    public function store(StorePaymentRequest $request)
    {
        Payment::create($request->validated());
        return redirect()->route('payments.index')->with('success', 'Manual payment recorded successfully.');
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());
        return redirect()->route('payments.index')->with('success', 'Payment status updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment record deleted.');
    }
}
