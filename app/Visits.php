<?php
/**
 * Created by PhpStorm.
 * User: lachlan
 * Date: 31/7/18
 * Time: 7:02 PM
 */

namespace App;


use Illuminate\Support\Facades\Redis;

class Visits
{

    protected $thread;
    /**
     * Visits constructor.
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?: 0;
    }

    public function record()
    {
        Redis::incr($this->cacheKey());
    }

    protected function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }
}