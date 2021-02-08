<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use DatabaseMigrations;

    function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply()
    {
        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);


        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'some reply here'
        ]);


        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    public function test_a_user_can_fetch_their_unread_notifications(){
        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'some reply here'
        ]);

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();

        $this->assertCount(1, $response);
    }

    public function test_a_user_can_mark_as_read()
    {
        $this->signIn();

        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;
        $name = auth()->user()->name;

        $this->delete("/profiles/{$name}/notifications/{$notificationId}");

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }

}
