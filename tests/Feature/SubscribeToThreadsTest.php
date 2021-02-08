<?php


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);
        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply here'
        ]);
    }
    /** @test */
    public function a_user_can_subscribe_from_threads()
    {
        $this->signIn();
        $thread = create(\App\Thread::class);
        $thread->subscribe();
        $this->delete($thread->path() . '/subscriptions');
        $this->assertCount(0, $thread->subscriptions);
    }


}
