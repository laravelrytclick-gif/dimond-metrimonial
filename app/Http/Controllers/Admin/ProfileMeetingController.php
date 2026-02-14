<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileMeeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileMeetingController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $meetings = $profile->meetings()
            ->with(['scheduledBy', 'matchedProfile'])
            ->latest()
            ->paginate(10);

        return view('profiles.meetings.index', compact('profile', 'meetings'));
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $profiles = Profile::where('id', '!=', $profile->id)
            ->pluck('full_name', 'id');
            
        $users = User::pluck('name', 'id');

        return view('profiles.meetings.create', [
            'profile' => $profile,
            'meetingTypes' => ProfileMeeting::getMeetingTypes(),
            'profiles' => $profiles,
            'users' => $users
        ]);
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'meeting_type' => 'required|in:family,individual',
            'matched_profile_id' => 'nullable|exists:profiles,id',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'venue' => 'required|string|max:120',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:users,id',
            'status' => 'required|in:scheduled,completed,cancelled',
            'outcome' => 'nullable|string|max:100',
            'next_action_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $meeting = $profile->meetings()->create([
            ...$validated,
            'scheduled_by' => Auth::id(),
            'attendees' => $validated['attendees'] ?? [],
        ]);

        return redirect()
            ->route('profiles.meetings.index', $profile)
            ->with('success', 'Meeting scheduled successfully!');
    }

    public function edit(Profile $profile, ProfileMeeting $meeting)
    {
        $this->authorize('update', $profile);
        
        $profiles = Profile::where('id', '!=', $profile->id)
            ->pluck('full_name', 'id');
            
        $users = User::pluck('name', 'id');

        return view('profiles.meetings.edit', [
            'profile' => $profile,
            'meeting' => $meeting,
            'meetingTypes' => ProfileMeeting::getMeetingTypes(),
            'statuses' => ProfileMeeting::getStatuses(),
            'profiles' => $profiles,
            'users' => $users
        ]);
    }

    public function update(Request $request, Profile $profile, ProfileMeeting $meeting)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'meeting_type' => 'required|in:family,individual',
            'matched_profile_id' => 'nullable|exists:profiles,id',
            'meeting_date' => 'required|date',
            'meeting_time' => 'required|date_format:H:i',
            'venue' => 'required|string|max:120',
            'attendees' => 'nullable|array',
            'attendees.*' => 'exists:users,id',
            'status' => 'required|in:scheduled,completed,cancelled',
            'outcome' => 'nullable|string|max:100',
            'next_action_date' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        $meeting->update([
            ...$validated,
            'attendees' => $validated['attendees'] ?? [],
        ]);

        return redirect()
            ->route('profiles.meetings.index', $profile)
            ->with('success', 'Meeting updated successfully!');
    }

    public function destroy(Profile $profile, ProfileMeeting $meeting)
    {
        $this->authorize('update', $profile);
        
        $meeting->delete();

        return back()->with('success', 'Meeting deleted successfully!');
    }
}