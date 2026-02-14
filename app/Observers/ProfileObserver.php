<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\ProfileStatusHistory;

class ProfileObserver
{
    public function updated(Profile $profile)
    {
        if ($profile->isDirty('status')) {
            ProfileStatusHistory::recordStatusChange(
                $profile,
                $profile->getOriginal('status'),
                $profile->status,
                request('status_change_reason')
            );
        }
    }
}