<?php

namespace App\Policies;

use App\User;
use App\Models\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;


    /**
     * Determine if the given user can delete the given tag.
     *
     * @param  User $user
     * @param  Tag $tag
     * @return bool
     */
    public function destroy(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    /**
     * Determine if the given user can update the given tag.
     *
     * @param  User $user
     * @param  Tag $tag
     * @return bool
     */
    public function update(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

    /**
     * Determine if the given user can see the given tag.
     *
     * @param  User $user
     * @param  Tag $tag
     * @return bool
     */
    public function show(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
    /**
     * Determine if the given user can create an tag.
     *
     * @param  User $user
     * @param  Tag $tag
     * @return bool
     */
    public function create(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }

}