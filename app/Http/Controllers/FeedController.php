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
        $type = $request['type'];
        if (!empty($type) && !in_array($type, ['audio', 'video', 'post', 'event'])) {
            return response()->json('invalid feed type', 422);
        }
        $user = Auth::user();
        $following = $user->following()->pluck('user_id');

        $feeds = Feed::with([
            'parentable' => function (MorphTo $morphTo) {
                $morphTo->morphWithCount([
                    AudioPost::class => ['comments', 'likes', 'views'],
                    VideoPost::class => ['comments', 'likes', 'views'],
                    Post::class => ['comments', 'likes', 'views'],
                    Event::class => ['comments', 'attendees', 'views'],
                ]);

                $morphTo->morphWith([
                    AudioPost::class => [],
                    Post::class => [],
                    Photo::class => [],
                ]);
            }
        ])
        
        ->whereIn('postable_id', $following)
        ->orderBy('created_at', 'desc');
        if (!empty($type)) {
            $feeds = $feeds->where('parentable_type', $type);
        }
        $feeds = $feeds->paginate();
        $result = new FeedCollection($feeds);
        return response()->json($result);
    }

    public function populate()
    {
    }
}
