<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;
use Illuminate\Support\Facades\Gate;
use App\Http\Forms\CreatePostForm;
use App\Notifications\YouWereMentioned;
use App\User;

class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Persist a new reply.
     *
     * @param  integer $channelId
     * @param  Thread  $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread, CreatePostForm $form)
    {
        $reply = $thread->addReply([ 
            'body' => request('body'), 
            'user_id' => auth()->id()
        ]);

        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);
    
        $names = $matches[1];
        $users = User::whereIn('name', $names)->get();

        foreach($users as $user) {
            $user->notify(new YouWereMentioned($reply));
        }

        $reply->load('owner');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if(request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validate(request(), ['body' => 'required|spamfree']);

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return reponse('Sorry, your reply could not be updated', 422);
        }

        return $reply;
    }
}
