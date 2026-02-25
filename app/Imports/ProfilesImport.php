<?php

namespace App\Imports;

use App\Models\Profile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class ProfilesImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use SkipsFailures;
    
    protected $skipDuplicates;
    protected $successCount = 0;
    protected $skipCount = 0;
    protected $errorCount = 0;
    protected $errors = [];

    public function __construct($skipDuplicates = true)
    {
        $this->skipDuplicates = $skipDuplicates;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            try {
                // Check for duplicate email if skipDuplicates is enabled
                if ($this->skipDuplicates && Profile::where('email', $row['email'])->exists()) {
                    $this->skipCount++;
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
                    $this->errorCount++;
                    $this->errors[] = "Row " . ($index + 2) . ": " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Create the profile
                Profile::create($profileData);
                $this->successCount++;

            } catch (\Exception $e) {
                $this->errorCount++;
                $this->errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'dob' => 'nullable|date',
            'birth_time' => 'nullable|date_format:H:i',
            'income' => 'nullable|numeric',
        ];
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getSkipCount()
    {
        return $this->skipCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
