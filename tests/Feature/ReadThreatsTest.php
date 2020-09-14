<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreatsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    public function testAUserCanViewAllThreads()
    {
        $this->signIn();
        $this->get('/threads')->assertSee($this->thread->title);
    }

    public function testUserCanViewSingleThread()
    {
        $this->signIn();
        $this->get($this->thread->path())->assertSee($this->thread->title);
    }

    public function testUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $this->signIn();
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    function test_a_user_can_filter_threads_according_to_a_channel() {
        $channel = create(\App\Channel::class);
        $threadInChannel = create(\App\Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(\App\Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

}
