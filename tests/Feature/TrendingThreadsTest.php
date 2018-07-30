<?php

namespace Tests\Feature;

use App\Trending;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected $trending;

    /**
     * Setup our tests
     */
    protected function setUp()
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();

    }

    /** @test */
    function it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertCount(0, $this->trending->get());

        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $this->assertCount(1, $this->trending->get());
    }

    /** @test */
    function it_contains_information_about_the_thread()
    {
        $thread = create('App\Thread');

        $this->call('GET', $thread->path());

        $trending = $this->trending->get();

        $this->assertEquals($thread->title, $trending[0]->title);
    }
}
