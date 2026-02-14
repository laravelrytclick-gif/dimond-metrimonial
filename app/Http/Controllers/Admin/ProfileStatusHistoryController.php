<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileStatusHistory;
use Illuminate\Http\Request;

class ProfileStatusHistoryController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $histories = $profile->statusHistories()
            ->with('changedBy')
            ->latest('changed_at')
            ->paginate(10);

        return view('profiles.status-history.index', compact('profile', 'histories'));
    }

    public function updateStatus(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'new_status' => 'required|string|max:30',
            'reason' => 'nullable|string|max:1000'
        ]);

        $oldStatus = $profile->status;
        $profile->update(['status' => $validated['new_status']]);

        return redirect()
            ->route('profiles.status-history.index', $profile)
            ->with('success', 'Profile status updated successfully');
    }
}