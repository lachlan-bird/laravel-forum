<?php

namespace App;


use Illuminate\Support\Facades\Redis;

class Trending
{
    /**
     * @return string
     */
    private function cacheKey()
    {
        return app()->environment('testing') ? 'test_trending_threads' : 'trending_threads';
    }

    /**
     * @return array
     */
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, 4));
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
    }

    /**
     * @param Thread $thread
     */
    public function push(Thread $thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'path' => $thread->path()
        ]));
    }
}