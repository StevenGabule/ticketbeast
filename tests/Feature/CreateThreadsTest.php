<?php

namespace Tests\Feature;

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
        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());
        $this->get($thread->path())->assertSee($thread->title)->assertSee($thread->body);
    }
}
