<?php

namespace App\Policies;

use App\User;
use App\Models\Worklog;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorklogPolicy
{
    use HandlesAuthorization;


    /**
     * Determine if the given user can delete the given worklog.
     *
     * @param  User $user
     * @param  Worklog $workLog
     * @return bool
     */
    public function destroy(User $user, Worklog $workLog)
    {
        return $user->id === $workLog->user_id;
    }

    /**
     * Determine if the given user can update the given worklog.
     *
     * @param  User $user
     * @param  Worklog $workLog
     * @return bool
     */
    public function update(User $user, Worklog $workLog)
    {
        return $user->id === $workLog->user_id;
    }

    /**
     * Determine if the given user can see the given worklog.
     *
     * @param  User $user
     * @param  Worklog $workLog
     * @return bool
     */
    public function show(User $user, Worklog $workLog)
    {
        return $user->id === $workLog->user_id;
    }
    /**
     * Determine if the given user can create an worklog.
     *
     * @param  User $user
     * @param  Worklog $workLog
     * @return bool
     */
    public function create(User $user, Worklog $workLog)
    {
        return $user->id === $workLog->user_id;
    }

}