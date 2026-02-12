<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileBackground;
use Illuminate\Http\Request;

class ProfileBackgroundController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('view', $profile);
        $backgrounds = $profile->backgrounds()->latest('year_from')->get();
        return view('profiles.backgrounds.index', compact('profile', 'backgrounds'));
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        $types = ProfileBackground::getTypes();
        return view('profiles.backgrounds.create', compact('profile', 'types'));
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'type' => 'required|in:education,profession',
            'title' => 'required|string|max:120',
            'organization' => 'required|string|max:120',
            'specialization' => 'nullable|string|max:120',
            'location' => 'nullable|string|max:120',
            'year_from' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'year_to' => 'nullable|digits:4|integer|min:1900|gt:year_from|max:' . (date('Y') + 1),
            'income' => 'nullable|string|max:50',
        ]);

        $profile->backgrounds()->create($validated);

        return redirect()->route('profiles.backgrounds.index', $profile)
            ->with('success', 'Background information added successfully.');
    }

    public function edit(Profile $profile, ProfileBackground $background)
    {
        $this->authorize('update', $profile);
        $types = ProfileBackground::getTypes();
        return view('profiles.backgrounds.edit', compact('profile', 'background', 'types'));
    }

    public function update(Request $request, Profile $profile, ProfileBackground $background)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'type' => 'required|in:education,profession',
            'title' => 'required|string|max:120',
            'organization' => 'required|string|max:120',
            'specialization' => 'nullable|string|max:120',
            'location' => 'nullable|string|max:120',
            'year_from' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'year_to' => 'nullable|digits:4|integer|min:1900|gt:year_from|max:' . (date('Y') + 1),
            'income' => 'nullable|string|max:50',
        ]);

        $background->update($validated);

        return redirect()->route('profiles.backgrounds.index', $profile)
            ->with('success', 'Background information updated successfully.');
    }

    public function destroy(Profile $profile, ProfileBackground $background)
    {
        $this->authorize('update', $profile);
        $background->delete();
        
        return redirect()->route('profiles.backgrounds.index', $profile)
            ->with('success', 'Background information removed successfully.');
    }
}