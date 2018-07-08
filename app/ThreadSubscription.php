<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;

class ThreadSubscription extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread() 
    {
        $this->belongsTo(Thread::class);
    }

    public function notify($thread, $reply)
    {
        return $this->user->notify(new ThreadWasUpdated($thread, $reply));
    }
}
