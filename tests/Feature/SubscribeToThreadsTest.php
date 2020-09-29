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
}
