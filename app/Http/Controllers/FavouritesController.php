<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Favourite;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    /**
     * FavouritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Reply $reply)
    {
        $reply->favourite();

        return back();
    }

    /**
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavourite();
    }
}
