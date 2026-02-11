<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileFamily;
use Illuminate\Http\Request;

class ProfileFamilyController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('view', $profile);
        $familyMembers = $profile->familyMembers()->latest()->get();
        return view('profiles.family.index', compact('profile', 'familyMembers'));
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        $memberTypes = ProfileFamily::getMemberTypes();
        return view('profiles.family.create', compact('profile', 'memberTypes'));
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'member_type' => 'required|in:father,mother,brother,sister,other',
            'name' => 'required|string|max:120',
            'age' => 'nullable|integer|min:0|max:150',
            'occupation' => 'nullable|string|max:120',
            'marital_status' => 'nullable|string|max:50',
            'living_with_candidate' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $profile->familyMembers()->create($validated);

        return redirect()->route('profiles.family.index', $profile)
            ->with('success', 'Family member added successfully.');
    }

    public function edit(Profile $profile, ProfileFamily $family)
    {
        $this->authorize('update', $profile);
        $memberTypes = ProfileFamily::getMemberTypes();
        return view('profiles.family.edit', compact('profile', 'family', 'memberTypes'));
    }

    public function update(Request $request, Profile $profile, ProfileFamily $family)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'member_type' => 'required|in:father,mother,brother,sister,other',
            'name' => 'required|string|max:120',
            'age' => 'nullable|integer|min:0|max:150',
            'occupation' => 'nullable|string|max:120',
            'marital_status' => 'nullable|string|max:50',
            'living_with_candidate' => 'boolean',
            'notes' => 'nullable|string',
        ]);

        $family->update($validated);

        return redirect()->route('profiles.family.index', $profile)
            ->with('success', 'Family member updated successfully.');
    }

    public function destroy(Profile $profile, ProfileFamily $family)
    {
        $this->authorize('update', $profile);
        $family->delete();
        
        return redirect()->route('profiles.family.index', $profile)
            ->with('success', 'Family member removed successfully.');
    }
}