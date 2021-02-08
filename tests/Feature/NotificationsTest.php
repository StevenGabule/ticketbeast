<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->signIn();
    }

    function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply()
    {

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

        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson("/profiles/". auth()->user()->name ."/notifications")->json());
    }

    public function test_a_user_can_mark_as_read()
    {

        create(DatabaseNotification::class);

        tap(auth()->user(), function($user) {
            $this->assertCount(1, $user->unreadNotifications);
            $this->delete("/profiles/{$user->name}/notifications/" . $user->unreadNotifications->first()->id);
            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }

}
