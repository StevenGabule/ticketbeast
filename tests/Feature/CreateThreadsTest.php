<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testGuestsMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());
    }

    public function testGuestsCannotSeeTheCreateThreadPage()
    {
        $this->withExceptionHandling()->get('/threads/create')->assertRedirect('/login');
    }

    public function testAnAuthenticatedUserCanCreateNewForumThreads()
    {
        $this->signIn();
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);
    }
}
