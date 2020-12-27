<?php

namespace App\Http\Controllers;

use App\AudioPost;
use App\Event;
use App\Feed;
use App\Http\Resources\FeedCollection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FeedController extends Controller
{
    public function load(Request $request)
    {
        $user = Auth::user();
        $following = $user->following()->pluck('user_id');
        $feeds = Feed::with('parentable')->whereIn('postable_id', $following)->orderBy('created_at', 'desc')->paginate();
        $result = new FeedCollection($feeds);
        return response()->json($result);
    }

    public function populate()
    {
    }
}
