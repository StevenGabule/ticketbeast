<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);

        return back()->with('flash', 'Your reply has been left.');
    }

    /**
     * @param Reply $reply
     * @return Application|ResponseFactory|RedirectResponse|Response
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();
        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        };
        return back();
    }

    /**
     * @param Reply $reply
     * @throws AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
    }
}
