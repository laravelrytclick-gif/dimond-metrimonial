<?php
 
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;  
use App\Models\Profile;
use App\Models\User;

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

    public function bulkUploadForm()
    {
        return view('profiles.bulk-upload');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:10240', // 10MB max, only CSV
        ]);

        try {
            $skipDuplicates = $request->has('skip_duplicates');
            $file = $request->file('file');
            $path = $file->getRealPath();
            
            $successCount = 0;
            $skipCount = 0;
            $errorCount = 0;
            $errors = [];
            
            // Open and read the CSV file
            if (($handle = fopen($path, 'r')) !== FALSE) {
                $header = fgetcsv($handle, 1000, ','); // Read header row
                $rowNumber = 2; // Start from row 2 (after header)
                
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    try {
                        // Combine header with data
                        $row = array_combine($header, $data);
                        
                        // Check for duplicate email if skipDuplicates is enabled
                        if ($skipDuplicates && Profile::where('email', $row['email'] ?? '')->exists()) {
                            $skipCount++;
                            continue;
                        }

                        // Prepare data
                        $profileData = [
                            'first_name' => $row['first_name'] ?? '',
                            'last_name' => $row['last_name'] ?? '',
                            'gender' => $row['gender'] ?? '',
                            'email' => $row['email'] ?? '',
                            'phone' => $row['phone'] ?? '',
                            'user_code' => Profile::generateUserCode(),
                            'full_name' => ($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? ''),
                            'registration_date' => now(),
                            'user_id' => Auth::id(),
                            'status' => $row['status'] ?? 'Active',
                        ];

                        // Add optional fields if they exist
                        $optionalFields = [
                            'alternate_phone', 'dob', 'birth_time', 'birth_place', 'religion', 'caste', 'sub_caste',
                            'gotra', 'height', 'weight', 'complexion', 'blood_group', 'eating_habit',
                            'smoking_habit', 'drinking_habit', 'address', 'city', 'state', 'country',
                            'highest_education', 'occupation', 'income', 'work_location', 'marital_status'
                        ];

                        foreach ($optionalFields as $field) {
                            if (isset($row[$field]) && !empty($row[$field])) {
                                $profileData[$field] = $row[$field];
                            }
                        }

                        // Validate the data
                        $validator = Validator::make($profileData, [
                            'first_name' => 'required|string|max:255',
                            'last_name' => 'required|string|max:255',
                            'gender' => 'required|in:Male,Female,Other',
                            'email' => 'required|email|unique:profiles,email',
                            'phone' => 'required|string|max:20',
                        ]);

                        if ($validator->fails()) {
                            $errorCount++;
                            $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                            continue;
                        }

                        // Create the profile
                        Profile::create($profileData);
                        $successCount++;

                    } catch (\Exception $e) {
                        $errorCount++;
                        $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                    }
                    $rowNumber++;
                }
                fclose($handle);
            }
            
            $message = "Import completed: {$successCount} profiles imported successfully.";
            if ($skipCount > 0) {
                $message .= " {$skipCount} duplicates skipped.";
            }
            if ($errorCount > 0) {
                $message .= " {$errorCount} errors occurred.";
                session()->flash('import_errors', $errors);
            }
            
            return redirect()->route('profiles.bulk-upload.form')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->route('profiles.bulk-upload.form')
                ->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="profile_import_template.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'first_name',
                'last_name', 
                'gender',
                'email',
                'phone',
                'alternate_phone',
                'dob',
                'birth_time',
                'birth_place',
                'religion',
                'caste',
                'sub_caste',
                'gotra',
                'height',
                'weight',
                'complexion',
                'blood_group',
                'eating_habit',
                'smoking_habit',
                'drinking_habit',
                'address',
                'city',
                'state',
                'country',
                'highest_education',
                'occupation',
                'income',
                'work_location',
                'marital_status',
                'status'
            ]);
            
            // Sample data row
            fputcsv($file, [
                'John',
                'Doe',
                'Male',
                'john.doe@example.com',
                '1234567890',
                '0987654321',
                '1990-01-15',
                '10:30',
                'New York',
                'Hindu',
                'General',
                'Example',
                'Example',
                '5\'10"',
                '70',
                'Fair',
                'O+',
                'Vegetarian',
                'No',
                'No',
                '123 Main St',
                'New York',
                'NY',
                'USA',
                'Bachelor',
                'Software Engineer',
                '75000',
                'New York',
                'Single',
                'Active'
            ]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}