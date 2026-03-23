<?php

namespace App\Models;
use App\Services\ProfileNumberService;
use App\Rules\UniqueProfileNumber;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_code',
        'profile_number',
        'full_name',
        'first_name',
        'last_name',
        'gender',
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
        'phone',
        'alternate_phone',
        'email',
        'address',
        'city',
        'state',
        'country',
        'highest_education',
        'education_detail',
        'occupation',
        'occupation_detail',
        'income',
        'work_location',
        'rm_id',
        'tme_id',
        'me_id',
        'status',
        'membership_type',
        'payment_date',
        'has_been_visited',
        'last_visited_date',
        'marital_status',
        'profile_photo_path',
        'registration_date',
    ];

    protected $casts = [
        'dob' => 'date',
        'birth_time' => 'datetime:H:i',
        'registration_date' => 'date',
        'payment_date' => 'datetime',
        'last_visited_date' => 'datetime',
        'has_been_visited' => 'boolean',
        'income' => 'decimal:2',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate profile number on creation
        static::creating(function ($profile) {
            if (empty($profile->profile_number)) {
                $isPaid = $profile->membership_type === 'paid';
                $profile->profile_number = ProfileNumberService::generateProfileNumber($isPaid);
            }
        });
    }

    // Accessor for age
    public function getAgeAttribute()
    {
        return $this->dob ? $this->dob->age : null;
    }

    // Accessor for visited status text
    public function getVisitedStatusTextAttribute()
    {
        return $this->has_been_visited ? 'Visited' : 'Not Visited';
    }

    // Method to mark profile as visited
    public function markAsVisited()
    {
        $this->update([
            'has_been_visited' => true,
            'last_visited_date' => now()
        ]);
    }

    // Method to mark profile as not visited
    public function markAsNotVisited()
    {
        $this->update([
            'has_been_visited' => false,
            'last_visited_date' => null
        ]);
    }

    /**
     * Scope to filter profiles based on search criteria
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Age filter
        if (!empty($filters['age_from'])) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) >= ?', [$filters['age_from']]);
        }
        
        if (!empty($filters['age_to'])) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, dob, CURDATE()) <= ?', [$filters['age_to']]);
        }

        // Height filter (assuming height is stored in cm)
        if (!empty($filters['height_from'])) {
            $query->where('height', '>=', $this->convertHeightToCm($filters['height_from']));
        }
        
        if (!empty($filters['height_to'])) {
            $query->where('height', '<=', $this->convertHeightToCm($filters['height_to']));
        }

        // Array filters
        $arrayFilters = [
            'religion', 'caste', 'sub_caste', 'eating_habit', 'drinking_habit', 
            'smoking_habit', 'highest_education', 'marital_status',
            'occupation', 'income', 'city', 'state', 'country', 
            'work_location', 'gender', 'blood_group', 'complexion', 
            'gotra', 'status'
        ];

        foreach ($arrayFilters as $field) {
            if (!empty($filters[$field]) && is_array($filters[$field])) {
                $query->whereIn($field, $filters[$field]);
            }
        }

        return $query;
    }

    /**
     * Convert height format to cm
     */
    private function convertHeightToCm($height): int
    {
        // If height is already in cm
        if (is_numeric($height)) {
            return (int) $height;
        }

        // Convert feet'inches" format to cm
        if (preg_match("/(\d+)'(\d+)\"/", $height, $matches)) {
            $feet = (int) $matches[1];
            $inches = (int) $matches[2];
            return (int) (($feet * 12 + $inches) * 2.54);
        }

        return 0;
    }

    /**
     * Search across all profile fields
     */
    public static function searchAllFields($searchTerm)
    {
        return self::where(function ($query) use ($searchTerm) {
            $query->where('full_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('first_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('phone', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('address', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('city', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('state', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('country', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('occupation', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('religion', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('caste', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('sub_caste', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('highest_education', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('user_code', 'LIKE', "%{$searchTerm}%");
        });
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with RM (Relationship Manager)
    public function relationshipManager()
    {
        return $this->belongsTo(User::class, 'rm_id');
    }

    // Relationship with TME (Tele Marketing Executive)
    public function tme()
    {
        return $this->belongsTo(User::class, 'tme_id');
    }

    // Relationship with ME (Marketing Executive)
    public function me()
    {
        return $this->belongsTo(User::class, 'me_id');
    }

    // Generate a unique user code
    public static function generateUserCode()
    {
        do {
            $code = 'PROF' . strtoupper(Str::random(6));
        } while (self::where('user_code', $code)->exists());

        return $code;
    }

    public function familyMembers()
{
    return $this->hasMany(ProfileFamily::class);
}
// Relationship with ProfileBackground
public function backgrounds()
{
    return $this->hasMany(ProfileBackground::class);
}
// In app/Models/Profile.php

public function matchPreference()
{
    return $this->hasOne(ProfileMatchPreference::class);
}

// In app/Models/Profile.php

public function shortlists()
{
    return $this->hasMany(ProfileShortlist::class);
}

public function shortlistedBy()
{
    return $this->hasMany(ProfileShortlist::class, 'shortlisted_profile_id');
}
// In app/Models/Profile.php

public function callFollowups()
{
    return $this->hasMany(ProfileCallFollowup::class)->latest();
}
// In app/Models/Profile.php
public function meetings()
{
    return $this->hasMany(ProfileMeeting::class)->latest('meeting_date');
}
// In app/Models/Profile.php
public function sentProposals()
{
    return $this->hasMany(ProfileDispatchProposal::class, 'sender_profile_id');
}

public function receivedProposals()
{
    return $this->hasMany(ProfileDispatchProposal::class, 'receiver_profile_id');
}

// In app/Models/Profile.php
public function statusHistories()
{
    return $this->hasMany(ProfileStatusHistory::class)->latest('changed_at');
}

// In app/Models/Profile.php
public function finances()
{
    return $this->hasMany(ProfileFinance::class)->latest('payment_date');
}

public function getActiveSubscriptionAttribute()
{
    return $this->finances()
        ->where('expiry_date', '>=', now())
        ->orderBy('expiry_date', 'desc')
        ->first();
}

// In app/Models/Profile.php
public function attachments()
{
    return $this->hasMany(ProfileAttachment::class)->latest();
}

public function interactions()
{
    return $this->hasMany(ProfileInteraction::class)->latest('interaction_date');
}

public function photos()
{
    return $this->hasMany(ProfileAttachment::class)
        ->where('category', 'photo')
        ->latest();
}

public function biodatas()
{
    return $this->hasMany(ProfileAttachment::class)
        ->where('category', 'biodata')
        ->latest();
}

public function idProofs()
{
    return $this->hasMany(ProfileAttachment::class)
        ->where('category', 'id')
        ->latest();
}

}