<?php

use App\Reply;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreatsTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function testAUserCanViewAllThreads()
    {
        $this->get('/threads')->assertSee($this->thread->title);
    }

    public function testUserCanViewSingleThread()
    {
        $this->get($this->thread->path())->assertSee($this->thread->title);
    }

    public function testUserCanReadRepliesThatAreAssociatedWithAThread()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

}
