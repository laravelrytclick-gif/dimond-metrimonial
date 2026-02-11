<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('manage profiles') || $user->hasRole('rm');
    }

    public function view(User $user, Profile $profile)
    {
        return $user->can('manage profiles') || 
               $user->hasRole('rm') && $profile->rm_id === $user->id;
    }

    public function create(User $user)
    {
        return $user->can('manage profiles') || $user->hasRole('rm');
    }

    public function update(User $user, Profile $profile)
    {
        return $user->can('manage profiles') || 
               $user->hasRole('rm') && $profile->rm_id === $user->id;
    }

    public function delete(User $user, Profile $profile)
    {
        return $user->can('manage profiles');
    }
}