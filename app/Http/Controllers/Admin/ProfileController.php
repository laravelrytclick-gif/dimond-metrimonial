<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;  // Add this line
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
 
    // use App\Models\Profile;
// use Illuminate\Http\Request;
class ProfileController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage profiles')->except(['show', 'edit', 'update']);
    }

    public function index()
    {
        $profiles = Profile::with('user', 'relationshipManager')
            ->when(!auth()->user()->hasRole('admin'), function($query) {
                return $query->where('rm_id', auth()->id());
            })
            ->latest()
            ->paginate(10);

        return view('profiles.index', compact('profiles'));
    }

    public function create()
    {
        $rms = User::role('rm')->get();
        return view('profiles.create', compact('rms'));
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'first_name' => 'required|string|max:255',
    //         'last_name' => 'required|string|max:255',
    //         'gender' => 'required|in:Male,Female,Other',
    //         'email' => 'required|email|unique:profiles,email',
    //         'phone' => 'required|string|max:20',
    //         'rm_id' => 'nullable|exists:users,id',
    //         // Add validation for other fields as needed
    //     ]);

    //     $validated['user_code'] = Profile::generateUserCode();
    //     $validated['full_name'] = $validated['first_name'] . ' ' . $validated['last_name'];
    //     $validated['registration_date'] = now();

    //     $profile = Profile::create($validated);

    //     return redirect()->route('profiles.show', $profile)
    //         ->with('success', 'Profile created successfully.');
    // }


public function store(Request $request)
{
    $validated = $request->validate([
        'first_name'        => 'required|string|max:255',
        'last_name'         => 'required|string|max:255',
        'gender'            => 'required|in:Male,Female,Other',
        'email'             => 'required|email|unique:profiles,email',
        'phone'             => 'required|string|max:20',
        'rm_id'             => 'nullable|exists:users,id',

        // Optional fields
        'dob'               => 'nullable|date',
        'birth_time'        => 'nullable|date_format:H:i',
        'birth_place'       => 'nullable|string|max:255',
        'religion'          => 'nullable|string|max:255',
        'caste'             => 'nullable|string|max:255',
        'sub_caste'         => 'nullable|string|max:255',
        'gotra'             => 'nullable|string|max:255',
        'height'            => 'nullable|string|max:50',
        'weight'            => 'nullable|string|max:50',
        'complexion'        => 'nullable|string|max:100',
        'blood_group'       => 'nullable|string|max:10',
        'eating_habit'      => 'nullable|string|max:100',
        'smoking_habit'     => 'nullable|string|max:100',
        'drinking_habit'    => 'nullable|string|max:100',
        'alternate_phone'   => 'nullable|string|max:20',
        'address'           => 'nullable|string',
        'city'              => 'nullable|string|max:255',
        'state'             => 'nullable|string|max:255',
        'country'           => 'nullable|string|max:255',
        'highest_education' => 'nullable|string|max:255',
        'occupation'        => 'nullable|string|max:255',
        'income'            => 'nullable|numeric',
        'work_location'     => 'nullable|string|max:255',
        'marital_status'    => 'nullable|string|max:100',
        'status'            => 'nullable|string|max:50',
    ]);

    // Generate extra fields
    $validated['user_code'] = Profile::generateUserCode();
    $validated['full_name'] = $validated['first_name'] . ' ' . $validated['last_name'];
    $validated['registration_date'] = now();

    // Optional: default status
    $validated['status'] = $validated['status'] ?? 'active';
$validated['user_id'] = Auth::id();

    $profile = Profile::create($validated);

    return redirect()
        ->route('profiles.show', $profile->id)
        ->with('success', 'Profile created successfully.');
}


    public function show(Profile $profile)
    {
        $this->authorize('view', $profile);
        return view('profiles.show', compact('profile'));
    }

    public function edit(Profile $profile)
    {
        $this->authorize('update', $profile);
        $rms = User::role('rm')->get();
        return view('profiles.edit', compact('profile', 'rms'));
    }

    public function update(Request $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => [
                'required',
                'email',
                Rule::unique('profiles', 'email')->ignore($profile->id),
            ],
            'phone' => 'required|string|max:20',
            'rm_id' => 'nullable|exists:users,id',
            // Add validation for other fields as needed
        ]);

        $validated['full_name'] = $validated['first_name'] . ' ' . $validated['last_name'];

        $profile->update($validated);

        return redirect()->route('profiles.show', $profile)
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(Profile $profile)
    {
        $this->authorize('delete', $profile);
        $profile->delete();
        return redirect()->route('profiles.index')
            ->with('success', 'Profile deleted successfully.');
    }
}