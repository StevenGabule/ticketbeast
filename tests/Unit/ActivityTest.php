<?php


use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    function test_records_activity_when_a_thread_is_created()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => \App\Thread::class
        ]);

        $activity = \App\Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    function test_it_records_activity_when_a_reply_is_created() {
        $this->signIn();
        create(\App\Reply::class);
        $this->assertEquals(2, \App\Activity::count());
    }

    function test_it_fetches_a_feed_for_any_user() {
        $this->signIn();

        create(\App\Thread::class, ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update(['created_at' => \Carbon\Carbon::now()->subWeek()]);

        $feed = \App\Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(\Carbon\Carbon::now()->format('Y-m-d')));
        $this->assertTrue($feed->keys()->contains(\Carbon\Carbon::now()->subWeek()->format('Y-m-d')));
    }

}