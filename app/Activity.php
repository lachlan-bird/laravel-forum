<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

/**
 * Class Activity
 * @package App
 */
class Activity extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject() {
        return $this->morphTo();
    }

    /**
     * @param \App\User $user
     * @param int $take
     * @return static
     */
    public static function feed(User $user, int $take = 50) {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function($activity) {
                return $activity->created_at->format('Y-m-d');
        });
    }
}
