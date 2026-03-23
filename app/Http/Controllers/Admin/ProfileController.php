<?php
 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  
use App\Models\Profile;
use App\Models\User;
use App\Rules\UniqueProfileNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage profiles')->except(['show', 'edit', 'update']);
    }

    public function index()
    {
        $profiles = Profile::with(['user', 'relationshipManager', 'tme', 'me'])
            ->when(!auth()->user()->hasRole('admin'), function($query) {
                return $query->where('rm_id', auth()->id());
            })
            ->latest()
            ->paginate(50);

        return view('profiles.index-new', compact('profiles'));
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
        'membership_type'    => 'nullable|in:free,paid',
        'profile_number'     => ['nullable', 'string', 'max:8', new UniqueProfileNumber],
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
            $updateExisting = $request->has('update_existing');
            $file = $request->file('file');
            $path = $file->getRealPath();
            
            $successCount = 0;
            $skipCount = 0;
            $updateCount = 0;
            $errorCount = 0;
            $errors = [];
            
            // Open and read CSV file
            if (($handle = fopen($path, 'r')) !== FALSE) {
                $header = fgetcsv($handle, 1000, ','); // Read header row
                
                // Validate header
                if ($header === false || empty(array_filter($header))) {
                    fclose($handle);
                    return redirect()->back()->with('error', 'Invalid CSV file: Header row is missing or empty.');
                }
                
                // Check for required columns
                $requiredColumns = ['first_name', 'last_name', 'gender', 'email', 'phone'];
                $missingColumns = array_diff($requiredColumns, $header);
                if (!empty($missingColumns)) {
                    fclose($handle);
                    return redirect()->back()->with('error', 'Missing required columns: ' . implode(', ', $missingColumns));
                }
                
                $rowNumber = 2; // Start from row 2 (after header)
                
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    try {
                        // Skip empty rows
                        if (empty(array_filter($data, function($value) {
                            return $value !== null && $value !== '';
                        }))) {
                            $rowNumber++;
                            continue;
                        }
                        
                        // Validate that header and data have same number of elements
                        if (count($header) !== count($data)) {
                            $errorCount++;
                            $errors[] = "Row {$rowNumber}: Column mismatch. Expected " . count($header) . " columns, found " . count($data) . " columns.";
                            $rowNumber++;
                            continue;
                        }
                        
                        // Combine header with data
                        $row = array_combine($header, $data);
                        
                        // Clean and validate email
                        $email = trim($row['email'] ?? '');
                        if (empty($email)) {
                            $errorCount++;
                            $errors[] = "Row {$rowNumber}: Email is required";
                            $rowNumber++;
                            continue;
                        }
                        
                        // Check for duplicate email if skipDuplicates is enabled
                        if ($skipDuplicates) {
                            $existingProfile = Profile::where('email', $email)->first();
                            if ($existingProfile) {
                                $skipCount++;
                                $rowNumber++;
                                continue;
                            }
                        }
                        
                        // Update existing profile if updateExisting is enabled
                        if ($updateExisting) {
                            $existingProfile = Profile::where('email', $email)->first();
                            if ($existingProfile) {
                                $updateData = $this->prepareProfileData($row);
                                $existingProfile->update($updateData);
                                $updateCount++;
                                $rowNumber++;
                                continue;
                            }
                        }
                        
                        // Prepare data
                        $profileData = $this->prepareProfileData($row);
                        
                        // Validate required fields
                        $validator = Validator::make($profileData, [
                            'first_name' => 'required|string|max:255',
                            'last_name' => 'required|string|max:255',
                            'gender' => 'required|in:Male,Female,Other',
                            'email' => 'required|email|unique:profiles,email,' . ($updateExisting && isset($existingProfile) ? $existingProfile->id : 'NULL'),
                            'phone' => 'required|string|max:20',
                        ]);

                        if ($validator->fails()) {
                            $errorCount++;
                            $errors[] = "Row {$rowNumber}: " . implode(', ', $validator->errors()->all());
                            $rowNumber++;
                            continue;
                        }

                        // Create profile
                        Profile::create($profileData);
                        $successCount++;

                    } catch (\Exception $e) {
                        $errorCount++;
                        $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                    }
                    $rowNumber++;
                }
                fclose($handle);
            } else {
                return redirect()->back()->with('error', 'Unable to open the uploaded file. Please check file permissions and format.');
            }
            
            $message = "Import completed: {$successCount} profiles imported successfully.";
            if ($skipCount > 0) {
                $message .= " {$skipCount} duplicates skipped.";
            }
            if ($updateCount > 0) {
                $message .= " {$updateCount} profiles updated.";
            }
            if ($errorCount > 0) {
                $message .= " {$errorCount} errors occurred.";
            }
            
            if (!empty($errors)) {
                return redirect()->back()
                    ->with('success', $message)
                    ->with('import_errors', $errors);
            }
            
            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }
    
    private function prepareProfileData($row)
    {
        return [
            'first_name' => trim($row['first_name'] ?? ''),
            'last_name' => trim($row['last_name'] ?? ''),
            'gender' => trim($row['gender'] ?? ''),
            'email' => trim($row['email'] ?? ''),
            'phone' => trim($row['phone'] ?? ''),
            'alternate_phone' => trim($row['alternate_phone'] ?? null),
            'dob' => !empty($row['dob']) ? date('Y-m-d', strtotime($row['dob'])) : null,
            'birth_time' => !empty($row['birth_time']) ? $row['birth_time'] : null,
            'birth_place' => trim($row['birth_place'] ?? null),
            'religion' => trim($row['religion'] ?? null),
            'caste' => trim($row['caste'] ?? null),
            'sub_caste' => trim($row['sub_caste'] ?? null),
            'gotra' => trim($row['gotra'] ?? null),
            'height' => trim($row['height'] ?? null),
            'weight' => trim($row['weight'] ?? null),
            'complexion' => trim($row['complexion'] ?? null),
            'blood_group' => trim($row['blood_group'] ?? null),
            'eating_habit' => trim($row['eating_habit'] ?? null),
            'smoking_habit' => trim($row['smoking_habit'] ?? null),
            'drinking_habit' => trim($row['drinking_habit'] ?? null),
            'address' => trim($row['address'] ?? null),
            'city' => trim($row['city'] ?? null),
            'state' => trim($row['state'] ?? null),
            'country' => trim($row['country'] ?? null),
            'highest_education' => trim($row['highest_education'] ?? null),
            'occupation' => trim($row['occupation'] ?? null),
            'income' => !empty($row['income']) ? floatval($row['income']) : null,
            'work_location' => trim($row['work_location'] ?? null),
            'marital_status' => trim($row['marital_status'] ?? null),
            'rm_id' => !empty($row['rm_id']) ? intval($row['rm_id']) : null,
            'user_code' => Profile::generateUserCode(),
            'full_name' => trim($row['first_name'] ?? '') . ' ' . trim($row['last_name'] ?? ''),
            'registration_date' => now(),
            'user_id' => Auth::id(),
            'status' => trim($row['status'] ?? 'Active'),
        ];
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="profile_import_template.csv"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // CSV headers with all available fields
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
                'rm_id',
                'status'
            ]);
            
            // Sample data row
            fputcsv($file, [
                'John',
                'Doe',
                'Male',
                'john.doe@example.com',
                '+1234567890',
                '+0987654321',
                '1990-01-15',
                '14:30',
                'Mumbai',
                'Hindu',
                'Brahmin',
                'Sharma',
                'Kashyap',
                '5\'10"',
                '70kg',
                'Fair',
                'O+',
                'Vegetarian',
                'No',
                'No',
                '123 Main St, Mumbai',
                'Mumbai',
                'Maharashtra',
                'India',
                'Graduate',
                'Software Engineer',
                '500000',
                'Pune',
                'Unmarried',
                '123',
                'Active'
            ]);
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}