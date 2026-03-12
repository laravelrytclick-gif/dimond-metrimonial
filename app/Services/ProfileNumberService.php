<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileNumberService
{
    const FREE_PREFIX = '22';
    const PAID_PREFIX = '66';
    const PROFILE_NUMBER_LENGTH = 8;

    /**
     * Generate a unique profile number for a new profile
     */
    public static function generateProfileNumber(bool $isPaid = false): string
    {
        $prefix = $isPaid ? self::PAID_PREFIX : self::FREE_PREFIX;
        $maxAttempts = 100;
        $attempts = 0;

        do {
            $profileNumber = self::generateRandomNumber($prefix);
            
            if (!self::profileNumberExists($profileNumber)) {
                return $profileNumber;
            }
            
            $attempts++;
        } while ($attempts < $maxAttempts);

        // Fallback to sequential generation if random fails
        return self::generateSequentialNumber($prefix);
    }

    /**
     * Convert free profile number to paid profile number
     */
    public static function convertToPaidNumber(string $freeProfileNumber): ?string
    {
        if (!self::isValidFreeProfileNumber($freeProfileNumber)) {
            Log::error("Invalid free profile number provided for conversion: {$freeProfileNumber}");
            return null;
        }

        $suffix = substr($freeProfileNumber, 2);
        $paidProfileNumber = self::PAID_PREFIX . $suffix;

        // Ensure the paid number doesn't already exist
        if (self::profileNumberExists($paidProfileNumber)) {
            Log::error("Paid profile number already exists: {$paidProfileNumber}");
            return null;
        }

        return $paidProfileNumber;
    }

    /**
     * Generate a random profile number with given prefix
     */
    private static function generateRandomNumber(string $prefix): string
    {
        $suffixLength = self::PROFILE_NUMBER_LENGTH - strlen($prefix);
        $maxSuffix = pow(10, $suffixLength) - 1;
        $suffix = str_pad(random_int(0, $maxSuffix), $suffixLength, '0', STR_PAD_LEFT);
        
        return $prefix . $suffix;
    }

    /**
     * Generate a sequential profile number with given prefix
     */
    private static function generateSequentialNumber(string $prefix): string
    {
        $suffixLength = self::PROFILE_NUMBER_LENGTH - strlen($prefix);
        
        $lastProfile = Profile::where('profile_number', 'like', $prefix . '%')
            ->orderBy('profile_number', 'desc')
            ->first();

        if ($lastProfile) {
            $lastSuffix = (int) substr($lastProfile->profile_number, 2);
            $newSuffix = $lastSuffix + 1;
        } else {
            $newSuffix = 1;
        }

        return $prefix . str_pad($newSuffix, $suffixLength, '0', STR_PAD_LEFT);
    }

    /**
     * Check if profile number already exists
     */
    private static function profileNumberExists(string $profileNumber): bool
    {
        return Profile::where('profile_number', $profileNumber)->exists();
    }

    /**
     * Validate if the given number is a valid free profile number
     */
    private static function isValidFreeProfileNumber(string $profileNumber): bool
    {
        return strlen($profileNumber) === self::PROFILE_NUMBER_LENGTH &&
               str_starts_with($profileNumber, self::FREE_PREFIX);
    }

    /**
     * Get profile number type (free or paid)
     */
    public static function getProfileNumberType(string $profileNumber): string
    {
        if (str_starts_with($profileNumber, self::FREE_PREFIX)) {
            return 'free';
        } elseif (str_starts_with($profileNumber, self::PAID_PREFIX)) {
            return 'paid';
        }
        
        return 'unknown';
    }

    /**
     * Validate profile number format
     */
    public static function isValidProfileNumber(string $profileNumber): bool
    {
        return strlen($profileNumber) === self::PROFILE_NUMBER_LENGTH &&
               is_numeric($profileNumber) &&
               (str_starts_with($profileNumber, self::FREE_PREFIX) || 
                str_starts_with($profileNumber, self::PAID_PREFIX));
    }

    /**
     * Update profile number when membership changes
     */
    public static function updateProfileNumber(Profile $profile, string $newMembershipType): bool
    {
        try {
            DB::beginTransaction();

            $currentType = self::getProfileNumberType($profile->profile_number);
            
            // Only convert from free to paid
            if ($currentType === 'free' && $newMembershipType === 'paid') {
                $newProfileNumber = self::convertToPaidNumber($profile->profile_number);
                
                if ($newProfileNumber) {
                    $profile->profile_number = $newProfileNumber;
                    $profile->membership_type = 'paid';
                    $profile->payment_date = now();
                    $profile->save();
                    
                    DB::commit();
                    Log::info("Profile number converted from {$profile->profile_number} to {$newProfileNumber}");
                    return true;
                }
            }
            
            DB::rollBack();
            return false;
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating profile number: " . $e->getMessage());
            return false;
        }
    }
}
