<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class SearchProfileController extends Controller
{
    /**
     * Display the search form
     */
    public function index()
    {
        // Fetch dynamic data for dropdowns
        $religions = Profile::distinct()->whereNotNull('religion')->pluck('religion')->filter();
        $castes = Profile::distinct()->whereNotNull('caste')->pluck('caste')->filter();
        $subCastes = Profile::distinct()->whereNotNull('sub_caste')->pluck('sub_caste')->filter();
        $eatingHabits = Profile::distinct()->whereNotNull('eating_habit')->pluck('eating_habit')->filter();
        $drinkingHabits = Profile::distinct()->whereNotNull('drinking_habit')->pluck('drinking_habit')->filter();
        $smokingHabits = Profile::distinct()->whereNotNull('smoking_habit')->pluck('smoking_habit')->filter();
        $educations = Profile::distinct()->whereNotNull('highest_education')->pluck('highest_education')->filter();
        $maritalStatuses = Profile::distinct()->whereNotNull('marital_status')->pluck('marital_status')->filter();
        $occupations = Profile::distinct()->whereNotNull('occupation')->pluck('occupation')->filter();
        $cities = Profile::distinct()->whereNotNull('city')->pluck('city')->filter();
        $states = Profile::distinct()->whereNotNull('state')->pluck('state')->filter();
        $countries = Profile::distinct()->whereNotNull('country')->pluck('country')->filter();
        $workLocations = Profile::distinct()->whereNotNull('work_location')->pluck('work_location')->filter();
        $genders = Profile::distinct()->whereNotNull('gender')->pluck('gender')->filter();
        $incomes = Profile::distinct()->whereNotNull('income')->pluck('income')->filter();
        $bloodGroups = Profile::distinct()->whereNotNull('blood_group')->pluck('blood_group')->filter();
        $complexions = Profile::distinct()->whereNotNull('complexion')->pluck('complexion')->filter();
        $gotras = Profile::distinct()->whereNotNull('gotra')->pluck('gotra')->filter();
        $statuses = Profile::distinct()->whereNotNull('status')->pluck('status')->filter();
        
        // Static options for fields that don't exist in database yet
        $residentialStatuses = ['Indian', 'Temporarily Abroad', 'NRI', 'Permanent Resident'];
        $astrologicallyOptions = ['Non Manglik', 'Slightly Manglik', 'Manglik'];
        $paymentStatuses = ['Paid', 'Un-paid'];
        
        return view('profiles.search', compact(
            'religions', 'castes', 'subCastes', 'eatingHabits', 'drinkingHabits', 
            'smokingHabits', 'educations', 'maritalStatuses', 
            'occupations', 'cities', 'states', 'countries', 'workLocations', 'genders', 'incomes',
            'bloodGroups', 'complexions', 'gotras', 'statuses',
            'residentialStatuses', 'astrologicallyOptions', 'paymentStatuses'
        ));
    }

    /**
     * Handle the search request
     */
    public function search(Request $request)
    {
        // Apply filters using the scope
        $profiles = Profile::filter($request->all())->paginate(20);

        return view('profiles.search-results', compact('profiles'));
    }

    /**
     * API endpoint for searching profiles
     */
    public function apiSearch(Request $request)
    {
        $searchTerm = $request->get('q');
        
        if (empty($searchTerm)) {
            return response()->json([]);
        }

        $profiles = Profile::searchAllFields($searchTerm)
            ->limit(10)
            ->get(['id', 'full_name', 'user_code', 'profile_photo_path']);

        return response()->json($profiles->map(function ($profile) {
            return [
                'id' => $profile->id,
                'text' => $profile->full_name . ' (' . $profile->user_code . ')',
                'photo' => $profile->profile_photo_path,
            ];
        }));
    }

    /**
     * Get filter options for the search form
     */
    public function getFilterOptions()
    {
        $options = [
            'religions' => Profile::distinct()->pluck('religion')->filter(),
            'castes' => Profile::distinct()->pluck('caste')->filter(),
            'eating_habits' => Profile::distinct()->pluck('eating_habit')->filter(),
            'drinking_habits' => Profile::distinct()->pluck('drinking_habit')->filter(),
            'smoking_habits' => Profile::distinct()->pluck('smoking_habit')->filter(),
            'educations' => Profile::distinct()->pluck('highest_education')->filter(),
            'marital_statuses' => Profile::distinct()->pluck('marital_status')->filter(),
            'occupations' => Profile::distinct()->pluck('occupation')->filter(),
            'cities' => Profile::distinct()->pluck('city')->filter(),
            'states' => Profile::distinct()->pluck('state')->filter(),
        ];

        return response()->json($options);
    }
}
