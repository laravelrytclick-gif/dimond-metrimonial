<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileInteraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileInteractionController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $interactions = $profile->interactions()
            ->with('createdBy')
            ->latest()
            ->paginate(15);

        return view('profiles.interactions.index', compact('profile', 'interactions'));
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $interactionTypes = ProfileInteraction::getInteractionTypes();
        $statuses = ProfileInteraction::getStatuses();
        $priorities = ProfileInteraction::getPriorities();
        
        return view('profiles.interactions.create', compact(
            'profile', 
            'interactionTypes', 
            'statuses', 
            'priorities'
        ));
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'interaction_type' => 'required|in:' . implode(',', array_keys(ProfileInteraction::getInteractionTypes())),
            'notes' => 'required|string|min:10',
            'interaction_date' => 'nullable|date|after_or_equal:today',
            'status' => 'nullable|in:' . implode(',', array_keys(ProfileInteraction::getStatuses())),
            'priority' => 'nullable|in:' . implode(',', array_keys(ProfileInteraction::getPriorities())),
        ]);

        $profile->interactions()->create([
            ...$validated,
            'created_by' => Auth::id(),
            'interaction_date' => $validated['interaction_date'] ?? now(),
            'status' => $validated['status'] ?? 'pending',
            'priority' => $validated['priority'] ?? 'medium',
        ]);

        return redirect()
            ->route('profiles.interactions.index', $profile)
            ->with('success', 'Interaction added successfully');
    }

    public function show(Profile $profile, ProfileInteraction $interaction)
    {
        $this->authorize('update', $profile);
        
        $interaction->load('createdBy');
        
        return view('profiles.interactions.show', compact('profile', 'interaction'));
    }

    public function edit(Profile $profile, ProfileInteraction $interaction)
    {
        $this->authorize('update', $profile);
        
        $interactionTypes = ProfileInteraction::getInteractionTypes();
        $statuses = ProfileInteraction::getStatuses();
        $priorities = ProfileInteraction::getPriorities();
        
        return view('profiles.interactions.edit', compact(
            'profile', 
            'interaction', 
            'interactionTypes', 
            'statuses', 
            'priorities'
        ));
    }

    public function update(Request $request, Profile $profile, ProfileInteraction $interaction)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'interaction_type' => 'required|in:' . implode(',', array_keys(ProfileInteraction::getInteractionTypes())),
            'notes' => 'required|string|min:10',
            'interaction_date' => 'nullable|date|after_or_equal:today',
            'status' => 'required|in:' . implode(',', array_keys(ProfileInteraction::getStatuses())),
            'priority' => 'required|in:' . implode(',', array_keys(ProfileInteraction::getPriorities())),
        ]);

        $interaction->update($validated);

        return redirect()
            ->route('profiles.interactions.index', $profile)
            ->with('success', 'Interaction updated successfully');
    }

    public function destroy(Profile $profile, ProfileInteraction $interaction)
    {
        $this->authorize('update', $profile);
        
        $interaction->delete();

        return redirect()
            ->route('profiles.interactions.index', $profile)
            ->with('success', 'Interaction deleted successfully');
    }
}
