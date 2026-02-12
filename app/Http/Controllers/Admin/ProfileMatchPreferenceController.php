<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileMatchPreference;
use Illuminate\Http\Request;

class ProfileMatchPreferenceController extends Controller
{
    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile);
        $preference = $profile->matchPreference ?? new ProfileMatchPreference([
            'preferences' => ProfileMatchPreference::getDefaultPreferences()
        ]);
        
        return view('profiles.match-preferences.edit', compact('profile', 'preference'));
    }

    public function update(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'preferences' => 'required|array',
            'comments' => 'nullable|string',
        ]);

        $preferences = $profile->matchPreference()->updateOrCreate(
            ['profile_id' => $profile->id],
            [
                'preferences' => $validated['preferences'],
                'comments' => $validated['comments'] ?? null
            ]
        );

        return redirect()->route('profiles.show', $profile)
            ->with('success', 'Match preferences updated successfully.');
    }
}