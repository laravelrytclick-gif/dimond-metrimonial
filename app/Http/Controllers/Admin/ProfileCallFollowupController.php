<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileCallFollowup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileCallFollowupController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $calls = $profile->callFollowups()
            ->with('performedBy')
            ->latest()
            ->paginate(10);

        return view('profiles.calls.index', compact('profile', 'calls'));
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $callTypes = ProfileCallFollowup::getCallTypes();
        $statuses = ProfileCallFollowup::getDefaultStatuses();
        
        return view('profiles.calls.create', compact('profile', 'callTypes', 'statuses'));
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'call_type' => 'required|in:call,whatsapp,visit',
            'call_status' => 'required|string|max:50',
            'remarks' => 'nullable|string',
            'followup_date' => 'nullable|date',
        ]);

        $profile->callFollowups()->create([
            ...$validated,
            'performed_by' => Auth::id(),
        ]);

        return redirect()
            ->route('profiles.calls.index', $profile)
            ->with('success', 'Call log added successfully!');
    }

    public function edit(Profile $profile, ProfileCallFollowup $call)
    {
        $this->authorize('update', $profile);
        
        $callTypes = ProfileCallFollowup::getCallTypes();
        $statuses = ProfileCallFollowup::getDefaultStatuses();
        
        return view('profiles.calls.edit', compact('profile', 'call', 'callTypes', 'statuses'));
    }

    public function update(Request $request, Profile $profile, ProfileCallFollowup $call)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'call_type' => 'required|in:call,whatsapp,visit',
            'call_status' => 'required|string|max:50',
            'remarks' => 'nullable|string',
            'followup_date' => 'nullable|date',
        ]);

        $call->update($validated);

        return redirect()
            ->route('profiles.calls.index', $profile)
            ->with('success', 'Call log updated successfully!');
    }

    public function destroy(Profile $profile, ProfileCallFollowup $call)
    {
        $this->authorize('update', $profile);
        
        $call->delete();

        return back()->with('success', 'Call log deleted successfully!');
    }
}