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

        $this->assertCount(1, $thread->fresh()->subscriptions);



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
