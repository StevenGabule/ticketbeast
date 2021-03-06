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
            ->post('/threads/some-channel/1/replies', [])
            ->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserMayParticipateInForumThreads()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }

    function test_unauthorized_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);
        $this->delete("/replies/{$reply->id}")->assertRedirect('/login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    function test_authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    function test_authorized_users_can_update_replies() {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);
        $updatedReply = 'You been changed, fool';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas("replies", ['id' => $reply->id ,'body' => $updatedReply]);
    }

    function test_unauthorized_users_cannot_update_replies()
    {
        $this->withExceptionHandling();
        $reply = create(Reply::class);
        $this->patch("/replies/{$reply->id}")->assertRedirect('/login');
        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }
}
