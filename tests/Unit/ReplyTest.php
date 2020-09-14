<?php

namespace Tests\Unit;

use App\{Reply, User};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    function testItHasAnOwner()
    {
        $reply = factory(Reply::class)->create();
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
