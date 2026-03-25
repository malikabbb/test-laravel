<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ request('member', 'Member') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .receipt-card { border: none !important; box-shadow: none !important; }
        }
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl overflow-hidden receipt-card border border-slate-100">
        <!-- Receipt Header -->
        <div class="bg-slate-900 p-8 text-center relative">
            <div class="w-16 h-16 bg-orange-500 rounded-2xl mx-auto flex items-center justify-center shadow-lg shadow-orange-500/30 mb-4">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-white text-2xl font-extrabold tracking-tighter uppercase italic">FitPro Gym</h1>
            <p class="text-slate-400 text-xs font-bold mt-1 tracking-widest uppercase">Premium Fitness Center</p>
        </div>

        <div class="p-8">
            <div class="flex justify-between items-center border-b border-dashed border-slate-200 pb-6 mb-6">
                <div>
                    <p class="text-slate-400 text-[10px] font-extrabold uppercase tracking-widest">Receipt No.</p>
                    <p class="text-slate-900 font-bold font-mono">AG-{{ date('Ymd') }}-{{ rand(1000, 9999) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-slate-400 text-[10px] font-extrabold uppercase tracking-widest">Date</p>
                    <p class="text-slate-900 font-bold">{{ request('date', date('M d, Y')) }}</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-slate-500 font-bold text-sm">Member Name:</span>
                    <span class="text-slate-900 font-extrabold text-sm">{{ request('member', 'N/A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-bold text-sm">Membership Plan:</span>
                    <span class="text-slate-900 font-extrabold text-sm">{{ request('plan', 'N/A') }}</span>
                </div>
                <div class="flex justify-between pt-4 border-t border-slate-50">
                    <span class="text-slate-500 font-bold text-sm">Payment Method:</span>
                    <span class="text-slate-900 font-extrabold text-sm uppercase">{{ request('method', 'Cash') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 font-bold text-sm">Cashier ID:</span>
                    <span class="text-slate-900 font-extrabold text-sm">ADM-{{ rand(10, 99) }} (Receptionist)</span>
                </div>
            </div>

            <div class="mt-8 bg-slate-50 rounded-2xl p-6 text-center border border-slate-100">
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Total Amount Paid</p>
                <p class="text-4xl font-extrabold text-slate-900 tracking-tight">{{ request('price', '$0.00') }}</p>
            </div>

            <div class="mt-8 text-center">
                <div class="inline-block px-4 py-1.5 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-extrabold uppercase tracking-wider border border-emerald-200 mb-6">
                    Payment Verified & Signed
                </div>
                <p class="text-slate-400 text-[10px] leading-relaxed">Thank you for being a part of our community!<br>This is a computer generated receipt and does not require a signature.</p>
            </div>
        </div>

        <!-- Print Action -->
        <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-center space-x-4 no-print">
            <button onclick="window.print()" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-2xl font-extrabold shadow-xl shadow-orange-500/30 transition-all flex items-center scale-105 active:scale-95">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Confirm & Print
            </button>
            <button onclick="window.close()" class="bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-2xl font-bold hover:bg-slate-100 transition-all">
                Close
            </button>
        </div>
    </div>

    <!-- Background Decoration (Receipt-like) -->
    <div class="fixed top-0 left-0 w-full h-1 bg-orange-500 no-print"></div>

</body>
</html>
