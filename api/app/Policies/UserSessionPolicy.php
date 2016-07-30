<?php

namespace App\Policies;

use App\Models\UserSession;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserSessionPolicy
{
    use HandlesAuthorization;


    /**
     * Determine if the given user can delete the given user session.
     *
     * @param  UserSession $usersession
     * @return bool
     */
    public function destroy(UserSession $usersession)
    {
        return $usersession->api_token === Auth::user()->api_token;
    }

}