<?php

namespace Tests\Feature;

use App\{Reply, Thread, User};
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    public function testUnAuthenticatedUsersMayNotAddReplies()
    {
        $this->withExceptionHandling()
            ->post('/threads/some-channel/1/replies',[])
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }
}
