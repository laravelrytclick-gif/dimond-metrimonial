<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCallFollowup extends Model
{
    use HasFactory;
// protected $table = 'profile_followups';

    protected $fillable = [
        'profile_id',
        'call_type',
        'call_status',
        'remarks',
        'followup_date',
        'performed_by'
    ];

    protected $casts = [
        'followup_date' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public static function getCallTypes()
    {
        return [
            'call' => 'Phone Call',
            'whatsapp' => 'WhatsApp',
            'visit' => 'In-Person Visit',
        ];
    }

    public static function getDefaultStatuses()
    {
        return [
            'scheduled' => 'Scheduled',
            'completed' => 'Completed',
            'missed' => 'Missed',
            'rescheduled' => 'Rescheduled',
            'no_answer' => 'No Answer',
            'call_back' => 'Call Back Requested',
        ];
    }
}