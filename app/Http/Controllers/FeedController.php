<?php

namespace App\Http\Controllers;

use App\AudioPost;
use App\Event;
use App\Feed;
use App\Http\Resources\FeedCollection;
use App\User;
use App\VideoPost;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
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
        $userId = $user->id;
        $following = $user->following()->pluck('user_id');

        $feeds = Feed::with([
            'parentable' => function (MorphTo $morphTo) use ($userId) {
                $morphTo->morphWithCount([
                    AudioPost::class => [
                        'comments', 'likes', 'views',
                        'likes as liked' => function (Builder $query) use ($userId) {
                            $query->where('user_id', $userId);
                        },
                    ],
                    VideoPost::class => [
                        'comments', 'likes', 'views',
                        'likes as liked' => function (Builder $query) use ($userId) {
                            $query->where('user_id', $userId);
                        },
                    ],
                    Post::class => [
                        'comments', 'likes', 'views',
                        'likes as liked' => function (Builder $query) use ($userId) {
                            $query->where('user_id', $userId);
                        },
                    ],
                    Event::class => [
                        'comments', 'attendees',
                        'attendees as attending' => function (Builder $query) use ($userId) {
                            $query->where('user_id', $userId);
                        },
                        'views'
                    ],
                ]);

                $morphTo->morphWith([
                    AudioPost::class => ['user'],
                    VideoPost::class => ['user'],
                    Post::class => ['user'],
                    Event::class => ['poster', 'user'],
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
