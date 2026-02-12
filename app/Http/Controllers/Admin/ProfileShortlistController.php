<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileShortlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileShortlistController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $shortlists = $profile->shortlists()
            ->with('shortlistedProfile')
            ->latest()
            ->paginate(10);

        return view('profiles.shortlists.index', compact('profile', 'shortlists'));
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $request->validate([
            'shortlisted_profile_id' => 'required|exists:profiles,id|not_in:' . $profile->id,
        ]);

        $profile->shortlists()->updateOrCreate(
            [
                'shortlisted_profile_id' => $request->shortlisted_profile_id,
            ],
            [
                'shortlisted_by' => Auth::id(),
            ]
        );

        return back()->with('success', 'Profile shortlisted successfully!');
    }

    public function destroy(Profile $profile, ProfileShortlist $shortlist)
    {
        $this->authorize('update', $profile);
        
        $shortlist->delete();

        return back()->with('success', 'Profile removed from shortlist!');
    }
}