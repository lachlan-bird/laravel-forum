<?php

namespace App\Policies;

use App\User;
use App\Reply;

use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ReplyPolicy
 * @package App\Policies
 */
class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        $lastReply = $user->fresh()->lastReply;

        if(!$lastReply) return true;

        return ! $lastReply->wasJustPublished();
    }

    /**
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }
}
