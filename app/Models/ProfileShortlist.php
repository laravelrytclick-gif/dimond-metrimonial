<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileShortlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'shortlisted_profile_id',
        'shortlisted_by'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function shortlistedProfile()
    {
        return $this->belongsTo(Profile::class, 'shortlisted_profile_id');
    }

    public function shortlistedBy()
    {
        return $this->belongsTo(User::class, 'shortlisted_by');
    }
}