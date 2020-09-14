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
        $this->withExceptionHandling();
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();
        $this->post('/threads/' .$thread->id. '/replies', $reply->toArray());
        $this->get($thread->path())->assertSee($reply->body);
    }

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->be($user = factory(User::class)->create());
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());
        $this->get('/threads/' . $thread->id)->assertSee($reply->body);
    }
}
