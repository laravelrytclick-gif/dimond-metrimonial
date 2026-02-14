<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\ProfileDispatchProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileDispatchProposalController extends Controller
{
    public function index(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $proposals = $profile->sentProposals()
            ->with(['receiverProfile', 'sentBy'])
            ->latest()
            ->paginate(10);

        return view('profiles.proposals.index', [
            'profile' => $profile,
            'proposals' => $proposals,
            'receivedProposals' => $profile->receivedProposals()
                ->with(['senderProfile', 'sentBy'])
                ->latest()
                ->paginate(10, ['*'], 'received_page')
        ]);
    }

    public function create(Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $profiles = Profile::where('id', '!=', $profile->id)
            ->pluck('full_name', 'id');

        return view('profiles.proposals.create', [
            'profile' => $profile,
            'profiles' => $profiles,
            'mediums' => ProfileDispatchProposal::getMediums(),
            'sides' => ProfileDispatchProposal::getSides(),
            'statuses' => ProfileDispatchProposal::getStatuses()
        ]);
    }

    public function store(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'receiver_profile_id' => 'required|exists:profiles,id',
            'medium' => 'required|in:email,whatsapp,manual',
            'side' => 'required|in:single,both',
            'proposal_status' => 'required|string|max:50',
            'notes' => 'nullable|string',
            'sent_at' => 'nullable|date'
        ]);

        $proposal = $profile->sentProposals()->create([
            ...$validated,
            'sent_by' => Auth::id(),
            'sent_at' => $validated['sent_at'] ?? now()
        ]);

        return redirect()
            ->route('profiles.proposals.index', $profile)
            ->with('success', 'Proposal dispatched successfully!');
    }

    public function show(Profile $profile, ProfileDispatchProposal $proposal)
    {
        $this->authorize('update', $profile);
        
        return view('profiles.proposals.show', [
            'profile' => $profile,
            'proposal' => $proposal->load(['senderProfile', 'receiverProfile', 'sentBy'])
        ]);
    }

    public function updateStatus(Request $request, Profile $profile, ProfileDispatchProposal $proposal)
    {
        $this->authorize('update', $profile);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,sent,viewed,accepted,rejected,expired'
        ]);

        $proposal->update(['proposal_status' => $validated['status']]);

        return back()->with('success', 'Proposal status updated successfully!');
    }
}