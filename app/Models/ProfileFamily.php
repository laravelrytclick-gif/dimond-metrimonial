<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'member_type',
        'name',
        'age',
        'occupation',
        'marital_status',
        'living_with_candidate',
        'notes'
    ];

    protected $casts = [
        'living_with_candidate' => 'boolean',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public static function getMemberTypes()
    {
        return [
            'father' => 'Father',
            'mother' => 'Mother',
            'brother' => 'Brother',
            'sister' => 'Sister',
            'other' => 'Other'
        ];
    }
}