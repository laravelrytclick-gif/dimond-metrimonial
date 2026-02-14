<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'matched_profile_id',
        'scheduled_by',
        'meeting_type',
        'meeting_date',
        'meeting_time',
        'venue',
        'attendees',
        'status',
        'outcome',
        'next_action_date',
        'notes'
    ];

    protected $casts = [
        'meeting_date' => 'date',
        'attendees' => 'array',
        'next_action_date' => 'date',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function matchedProfile()
    {
        return $this->belongsTo(Profile::class, 'matched_profile_id');
    }

    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public static function getMeetingTypes()
    {
        return [
            'family' => 'Family Meeting',
            'individual' => 'Individual Meeting'
        ];
    }

    public static function getStatuses()
    {
        return [
            'scheduled' => 'Scheduled',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];
    }

    public function getMeetingDateTimeAttribute()
    {
        return $this->meeting_date->format('Y-m-d') . ' ' . $this->meeting_time;
    }
}