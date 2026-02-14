<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'old_status',
        'new_status',
        'changed_by',
        'reason',
        'changed_at'
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public static function recordStatusChange(Profile $profile, string $oldStatus, string $newStatus, ?string $reason = null)
    {
        return static::create([
            'profile_id' => $profile->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->id(),
            'reason' => $reason,
            'changed_at' => now(),
        ]);
    }
}