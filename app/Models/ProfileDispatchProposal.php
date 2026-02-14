<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileDispatchProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_profile_id',
        'receiver_profile_id',
        'sent_by',
        'medium',
        'side',
        'proposal_status',
        'notes',
        'sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function senderProfile()
    {
        return $this->belongsTo(Profile::class, 'sender_profile_id');
    }

    public function receiverProfile()
    {
        return $this->belongsTo(Profile::class, 'receiver_profile_id');
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public static function getMediums()
    {
        return [
            'email' => 'Email',
            'whatsapp' => 'WhatsApp',
            'manual' => 'Manual'
        ];
    }

    public static function getSides()
    {
        return [
            'single' => 'Single Side',
            'both' => 'Both Sides'
        ];
    }

    public static function getStatuses()
    {
        return [
            'pending' => 'Pending',
            'sent' => 'Sent',
            'viewed' => 'Viewed',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'expired' => 'Expired'
        ];
    }
}