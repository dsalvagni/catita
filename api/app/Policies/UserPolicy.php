<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Worklog;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;


    /**
     * Determine if the given user can delete the given user.
     *
     * @param  User $user
     * @return bool
     */
    public function destroy(User $user)
    {
        return $user->id === Auth::user()->id;
    }

    /**
     * Determine if the given user can update the given user.
     *
     * @param  User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->id === Auth::user()->id;
    }

    /**
     * Determine if the given user can see the given worklog.
     *
     * @param  User $user
     * @return bool
     */
    public function show(User $user)
    {
        return $user->id === Auth::user()->id;
    }
}