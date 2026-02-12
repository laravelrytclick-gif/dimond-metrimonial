<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileMatchPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'preferences',
        'comments'
    ];

    protected $casts = [
        'preferences' => 'array',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public static function getDefaultPreferences()
    {
        return [
            'age_range' => [
                'min' => 25,
                'max' => 35
            ],
            'height_range' => [
                'min' => null,
                'max' => null
            ],
            'marital_status' => null,
            'religion' => null,
            'caste' => null,
            'sub_caste' => null,
            'education' => null,
            'occupation' => null,
            'income_range' => [
                'min' => null,
                'max' => null
            ],
            'eating_habits' => null,
            'drinking_habits' => null,
            'smoking_habits' => null,
        ];
    }
}