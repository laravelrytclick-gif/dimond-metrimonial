<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this line

class ProfileSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = Profile::query()
            ->select([
                'id',
                'user_code',
                'full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) as age'),
                'city',
                'state'
            ])
            ->where(function($q) use ($request) {
                $q->where('user_code', 'like', '%' . $request->q . '%')
                  ->orWhere('full_name', 'like', '%' . $request->q . '%')
                  ->orWhere('phone', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            })
            ->where('id', '!=', $request->profile_id) // Exclude current profile
            ->orderBy('full_name')
            ->paginate(10);

        $formattedResults = $query->map(function($profile) {
            return [
                'id' => $profile->id,
                'text' => $profile->full_name . ' (' . $profile->user_code . ')',
                'full_name' => $profile->full_name,
                'user_code' => $profile->user_code,
                'age' => $profile->age,
                'city' => $profile->city,
                'state' => $profile->state
            ];
        });

        return [
            'data' => $formattedResults,
            'current_page' => $query->currentPage(),
            'last_page' => $query->lastPage(),
            'total' => $query->total()
        ];
    }
}