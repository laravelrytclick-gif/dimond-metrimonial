<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'type',
        'title',
        'organization',
        'specialization',
        'location',
        'year_from',
        'year_to',
        'income'
    ];

    protected $casts = [
        'year_from' => 'integer',
        'year_to' => 'integer',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public static function getTypes()
    {
        return [
            'education' => 'Education',
            'profession' => 'Professional Experience'
        ];
    }

    public function getDurationAttribute()
    {
        $from = $this->year_from;
        $to = $this->year_to ?: 'Present';
        return "{$from} - {$to}";
    }
}