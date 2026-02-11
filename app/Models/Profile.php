<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_code',
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
        'occupation',
        'income',
        'work_location',
        'rm_id',
        'status',
        'marital_status',
        'profile_photo_path',
        'registration_date',
    ];

    protected $casts = [
        'dob' => 'date',
        'birth_time' => 'datetime:H:i',
        'registration_date' => 'date',
        'income' => 'decimal:2',
    ];

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
}