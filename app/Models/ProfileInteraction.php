<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'interaction_type',
        'notes',
        'created_by',
        'interaction_date',
        'status',
        'priority'
    ];

    protected $casts = [
        'interaction_date' => 'datetime',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getInteractionTypes(): array
    {
        return [
            'phone_call' => 'Phone Call',
            'email' => 'Email',
            'whatsapp' => 'WhatsApp',
            'visit' => 'Visit',
            'meeting' => 'Meeting',
            'followup' => 'Follow-up',
            'feedback' => 'Feedback',
            'other' => 'Other'
        ];
    }

    public static function getStatuses(): array
    {
        return [
            'pending' => 'Pending',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'rescheduled' => 'Rescheduled'
        ];
    }

    public static function getPriorities(): array
    {
        return [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent'
        ];
    }
}
