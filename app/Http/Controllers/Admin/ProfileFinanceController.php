<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileFinance;
use Illuminate\Http\Request;

class ProfileFinanceController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $transactions = $profile->finances()
            ->latest('payment_date')
            ->paginate(10);

        return view('profiles.finance.index', [
            'profile' => $profile,
            'transactions' => $transactions,
            'totalPaid' => $profile->finances()->sum('amount_paid')
        ]);
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        return view('profiles.finance.create', [
            'profile' => $profile,
            'paymentModes' => ProfileFinance::getPaymentModes(),
            'packageOptions' => ProfileFinance::getPackageOptions()
        ]);
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'package_name' => 'required|string|max:120',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:Cash,UPI,Bank',
            'expiry_date' => 'required|date|after_or_equal:payment_date',
            'remarks' => 'nullable|string'
        ]);

        $profile->finances()->create($validated);

        return redirect()
            ->route('profiles.finance.index', $profile)
            ->with('success', 'Payment recorded successfully');
    }

    public function show(Profile $profile, ProfileFinance $finance)
    {
        $this->authorize('update', $profile);
        
        return view('profiles.finance.show', [
            'profile' => $profile,
            'finance' => $finance
        ]);
    }

    public function edit(Profile $profile, ProfileFinance $finance)
    {
        $this->authorize('update', $profile);
        
        return view('profiles.finance.edit', [
            'profile' => $profile,
            'finance' => $finance,
            'paymentModes' => ProfileFinance::getPaymentModes(),
            'packageOptions' => ProfileFinance::getPackageOptions()
        ]);
    }

    public function update(Request $request, Profile $profile, ProfileFinance $finance)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'package_name' => 'required|string|max:120',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:Cash,UPI,Bank',
            'expiry_date' => 'required|date|after_or_equal:payment_date',
            'remarks' => 'nullable|string'
        ]);

        $finance->update($validated);

        return redirect()
            ->route('profiles.finance.index', $profile)
            ->with('success', 'Payment updated successfully');
    }

    public function destroy(Profile $profile, ProfileFinance $finance)
    {
        $this->authorize('update', $profile);
        
        $finance->delete();

        return back()->with('success', 'Payment record deleted successfully');
    }
}