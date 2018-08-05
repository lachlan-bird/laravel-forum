<?php
/**
 * Created by PhpStorm.
 * User: lachlan
 * Date: 31/7/18
 * Time: 7:02 PM
 */

namespace App;


use Illuminate\Support\Facades\Redis;

/**
 * Class Visits
 * @package App
 */
class Visits
{

    /**
     * @var
     */
    protected $thread;

    /**
     * Visits constructor.
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Resets number of visits to 0
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    /**
     * Returns number of visits
     *
     * @return int
     */
    public function count()
    {
        return Redis::get($this->cacheKey()) ?: 0;
    }

    /**
     * Records a visit to this entity
     */
    public function record()
    {
        Redis::incr($this->cacheKey());
    }

    /**
     * @return string
     */
    protected function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }
}