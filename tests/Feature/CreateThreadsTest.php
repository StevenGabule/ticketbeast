<?php

namespace Tests\Feature;

use App\Activity;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestsMayNotCreateThreads()
    {
        $this->withExceptionHandling();
        $this->get('/threads/create')->assertRedirect('/login');
        $this->post('/threads')->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());
        $this->get($response->headers->get('Location'))->assertSee($thread->title)->assertSee($thread->body);
    }

    function testAThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    function testAThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    function test_a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        return $this->post('/threads', $thread->toArray());
    }

    public function test_authorized_users_can_thread_can_be_deleted()
    {
        $this->signIn();
        $thread = create( 'App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    function test_authorized_users_guests_cannot_delete_threads() {
        $this->withExceptionHandling();

        $thread = create('App\Thread');
        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }
}
