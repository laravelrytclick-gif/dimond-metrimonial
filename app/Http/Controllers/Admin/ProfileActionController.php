<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Services\ProfileNumberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Hide/Unhide Profile
    public function toggleVisibility(Request $request)
    {
        $profileIds = $request->profile_ids;
        
        if (!is_array($profileIds)) {
            $profileIds = [$profileIds];
        }
        
        $profiles = Profile::whereIn('id', $profileIds)->get();
        $results = [];
        
        foreach ($profiles as $profile) {
            $profile->status = $profile->status === 'hidden' ? 'active' : 'hidden';
            $profile->save();
            $results[] = [
                'id' => $profile->id,
                'status' => $profile->status
            ];
        }
        
        return response()->json([
            'success' => true,
            'message' => count($profiles) . " profiles updated successfully",
            'results' => $results
        ]);
    }

    // Convert To Paid
    public function convertToPaid(Request $request)
    {
        $profileIds = $request->profile_ids;
        
        if (!is_array($profileIds)) {
            $profileIds = [$profileIds];
        }
        
        $profiles = Profile::whereIn('id', $profileIds)->get();
        $successCount = 0;
        $failureCount = 0;
        
        foreach ($profiles as $profile) {
            // Update profile number when converting to paid
            if (ProfileNumberService::updateProfileNumber($profile, 'paid')) {
                $successCount++;
            } else {
                $failureCount++;
            }
        }
        
        $message = $successCount > 0 
            ? "{$successCount} profiles converted to paid membership successfully" 
            : "No profiles were converted";
            
        if ($failureCount > 0) {
            $message .= ". {$failureCount} profiles failed to convert.";
        }
        
        return response()->json([
            'success' => $successCount > 0,
            'message' => $message,
            'success_count' => $successCount,
            'failure_count' => $failureCount
        ]);
    }

    // Change TME/RM/ME
    public function changeTeamMember(Request $request)
    {
        $profileIds = $request->profile_ids;
        
        if (!is_array($profileIds)) {
            $profileIds = [$profileIds];
        }
        
        $profiles = Profile::whereIn('id', $profileIds)->get();
        
        foreach ($profiles as $profile) {
            if ($request->has('rm_id')) $profile->rm_id = $request->rm_id;
            if ($request->has('tme_id')) $profile->tme_id = $request->tme_id;
            if ($request->has('me_id')) $profile->me_id = $request->me_id;
            $profile->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => count($profiles) . ' profiles team members updated successfully'
        ]);
    }

    // Mark Visited/Non-Visited
    public function markVisited(Request $request)
    {
        $profileIds = $request->profile_ids;
        $markAsVisited = $request->mark_as_visited ?? true;
        
        if (!is_array($profileIds)) {
            $profileIds = [$profileIds];
        }
        
        $profiles = Profile::whereIn('id', $profileIds)->get();
        $results = [];
        
        foreach ($profiles as $profile) {
            if ($markAsVisited) {
                $profile->markAsVisited();
                $status = 'visited';
            } else {
                $profile->markAsNotVisited();
                $status = 'not visited';
            }
            
            $results[] = [
                'id' => $profile->id,
                'status' => $status,
                'visited_status' => $profile->has_been_visited
            ];
        }
        
        $actionText = $markAsVisited ? 'marked as visited' : 'marked as not visited';
        
        return response()->json([
            'success' => true,
            'message' => count($profiles) . " profiles {$actionText} successfully",
            'results' => $results
        ]);
    }

    // Find Match
    public function findMatch(Request $request)
    {
        $profileId = $request->profile_id;
        $profile = Profile::findOrFail($profileId);
        
        // Calculate age from date of birth
        $profileAge = $profile->dob ? \Carbon\Carbon::parse($profile->dob)->age : null;
        
        // Find matching profiles based on basic criteria
        $matches = Profile::where('id', '!=', $profileId)
            ->where('gender', '!=', $profile->gender) // Opposite gender
            ->where('status', 'Active') // Only active profiles
            ->when($profile->religion, function($query, $religion) {
                return $query->where('religion', $religion);
            })
            ->when($profile->caste, function($query, $caste) {
                return $query->where('caste', $caste);
            })
            ->when($profileAge, function($query, $age) {
                // Match within reasonable age range (+/- 5 years)
                return $query->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) BETWEEN ? AND ?', [$age - 5, $age + 5]);
            })
            ->limit(10)
            ->get(['id', 'first_name', 'last_name', 'gender', 'dob', 'caste', 'religion', 'phone', 'email']);
        
        return response()->json([
            'success' => true,
            'matches' => $matches,
            'message' => 'Found ' . $matches->count() . ' potential matches'
        ]);
    }

    // Save Shortlist/Send Mail
    public function saveShortlist(Request $request)
    {
        $profileId = $request->profile_id;
        $targetProfileId = $request->target_profile_id;
        
        // Save shortlist logic here
        DB::table('profile_shortlists')->updateOrInsert([
            'profile_id' => $profileId,
            'target_profile_id' => $targetProfileId
        ], [
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Profile shortlisted successfully'
        ]);
    }

    // Hold/Release Profile
    public function toggleHold(Request $request)
    {
        $profileIds = $request->profile_ids;
        
        if (!is_array($profileIds)) {
            $profileIds = [$profileIds];
        }
        
        $profiles = Profile::whereIn('id', $profileIds)->get();
        $results = [];
        
        foreach ($profiles as $profile) {
            $profile->status = $profile->status === 'hold' ? 'active' : 'hold';
            $profile->save();
            $results[] = [
                'id' => $profile->id,
                'status' => $profile->status
            ];
        }
        
        return response()->json([
            'success' => true,
            'message' => count($profiles) . " profiles hold status updated successfully",
            'results' => $results
        ]);
    }

    // Add Interaction
    public function addInteraction(Request $request)
    {
        $profileId = $request->profile_id;
        
        DB::table('profile_interactions')->insert([
            'profile_id' => $profileId,
            'interaction_type' => $request->interaction_type,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
            'created_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Interaction added successfully'
        ]);
    }

    // Get Interactions Record
    public function getInteractions(Request $request)
    {
        $profileId = $request->profile_id;
        
        $interactions = DB::table('profile_interactions')
            ->where('profile_id', $profileId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'interactions' => $interactions
        ]);
    }

    // Add Follow-up
    public function addFollowup(Request $request)
    {
        $profileId = $request->profile_id;
        
        DB::table('profile_followups')->insert([
            'profile_id' => $profileId,
            'followup_date' => $request->followup_date,
            'notes' => $request->notes,
            'status' => 'pending',
            'created_by' => auth()->id(),
            'created_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Follow-up added successfully'
        ]);
    }

    // Add Feedback
    public function addFeedback(Request $request)
    {
        $profileId = $request->profile_id;
        
        DB::table('profile_feedback')->insert([
            'profile_id' => $profileId,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'created_by' => auth()->id(),
            'created_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Feedback added successfully'
        ]);
    }

    // Mark Done/Active
    public function toggleDoneActive(Request $request)
    {
        $profileIds = $request->profile_ids;
        
        if (!is_array($profileIds)) {
            $profileIds = [$profileIds];
        }
        
        $profiles = Profile::whereIn('id', $profileIds)->get();
        $results = [];
        
        foreach ($profiles as $profile) {
            $profile->status = $profile->status === 'done' ? 'active' : 'done';
            $profile->save();
            $results[] = [
                'id' => $profile->id,
                'status' => $profile->status
            ];
        }
        
        return response()->json([
            'success' => true,
            'message' => count($profiles) . " profiles status updated successfully",
            'results' => $results
        ]);
    }

    // Save Single Shortlist
    public function saveSingleShortlist(Request $request)
    {
        $profileId = $request->profile_id;
        $targetProfileId = $request->target_profile_id;
        
        DB::table('profile_shortlists')->updateOrInsert([
            'profile_id' => $profileId,
            'target_profile_id' => $targetProfileId
        ], [
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Single profile shortlisted successfully'
        ]);
    }

    // Add Meeting
    public function addMeeting(Request $request)
    {
        $profileId = $request->profile_id;
        
        DB::table('profile_meetings')->insert([
            'profile_id' => $profileId,
            'meeting_date' => $request->meeting_date,
            'meeting_time' => $request->meeting_time,
            'location' => $request->location,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
            'created_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Meeting scheduled successfully'
        ]);
    }

    // Update More Info
    public function updateMoreInfo(Request $request)
    {
        $profileId = $request->profile_id;
        $profile = Profile::findOrFail($profileId);
        
        $profile->update($request->only([
            'about_me', 'family_background', 'hobbies', 'expectations'
        ]));
        
        return response()->json([
            'success' => true,
            'message' => 'Profile information updated successfully'
        ]);
    }

    // Update Match Making
    public function updateMatchMaking(Request $request)
    {
        $profileId = $request->profile_id;
        $profile = Profile::findOrFail($profileId);
        
        $profile->update($request->only([
            'partner_preferences', 'age_range_min', 'age_range_max', 
            'height_preference', 'caste_preference', 'location_preference'
        ]));
        
        return response()->json([
            'success' => true,
            'message' => 'Match making preferences updated successfully'
        ]);
    }

    // Add Photo
    public function addPhoto(Request $request)
    {
        $profileId = $request->profile_id;
        
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('profile-photos', 'public');
            
            DB::table('profile_photos')->insert([
                'profile_id' => $profileId,
                'photo_path' => $photoPath,
                'is_primary' => $request->is_primary ?? false,
                'created_at' => now()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Photo added successfully',
                'photo_path' => $photoPath
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No photo uploaded'
        ]);
    }

    // Update Finance
    public function updateFinance(Request $request)
    {
        $profileId = $request->profile_id;
        $profile = Profile::findOrFail($profileId);
        
        DB::table('profile_finance')->updateOrInsert([
            'profile_id' => $profileId
        ], [
            'amount' => $request->amount,
            'payment_type' => $request->payment_type,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
            'updated_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Financial information updated successfully'
        ]);
    }
}
