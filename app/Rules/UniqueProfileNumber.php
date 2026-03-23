<?php

namespace App\Rules;

use App\Services\ProfileNumberService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueProfileNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!ProfileNumberService::isValidProfileNumber($value)) {
            $fail('The :attribute must be a valid 8-digit profile number starting with 22 or 66.');
            return;
        }

        $profileId = request()->route('profile')?->id;
        
        $query = \App\Models\Profile::where('profile_number', $value);
        
        if ($profileId) {
            $query->where('id', '!=', $profileId);
        }
        
        if ($query->exists()) {
            $fail('The :attribute has already been taken.');
        }
    }
}
