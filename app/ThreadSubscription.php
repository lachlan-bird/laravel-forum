<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

/**
 * Class ThreadSubscription
 * @package App
 */
class ThreadSubscription extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *
     */
    public function thread()
    {
        $this->belongsTo(Thread::class);
    }

    /**
     * @param $thread
     * @param $reply
     * @return mixed
     */
    public function notify($thread, $reply)
    {
        return $this->user->notify(new ThreadWasUpdated($thread, $reply));
    }
}
