<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_an_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_an_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => 'App\Reply'
        ]);

        $this->assertEquals(2, Activity::count());

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $reply->id);
    }

    /** @test */
    function it_fetches_a_feed_for_any_user()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()]);

        Carbon::setTestNow(Carbon::now()->subWeek());
        create('App\Thread', [
            'user_id' => auth()->id()
        ]);

        $feed = Activity::feed(auth()->user());

        Carbon::setTestNow(null);
        
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
