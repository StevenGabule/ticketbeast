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


    function test_a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create(\App\Channel::class);
        $threadInChannel = create(\App\Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(\App\Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    function test_a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');
        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    function test_a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $this->thread;
        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    function test_a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);
        $response = $this->getJson($thread->path() . '/replies')->json();
        $this->assertCount(1, $response['data']);
        $this->assertEquals(2, $response['total']);
    }

    public function test_a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $thread->id]);
        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response);
    }

}
