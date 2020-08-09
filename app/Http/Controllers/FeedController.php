<?php

namespace App\Http\Controllers;

use App\Feed;
use App\Http\Resources\FeedCollection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function load(Request $request)
    {
        $id = Auth::id();

        // $feed = Feed::where('poster_id',$id)
        $feeds = User::find($id)
            ->following()
            ->join('feeds', 'feeds.user_id', '=', 'followers.user_id')
            ->leftJoin('events', function ($join) {
                $join->on('followers.user_id', '=', 'events.user_id')
                     ->where('feeds.type', 'event');
            })
            ->leftJoin('audio_posts', function ($join) {
                $join->on('followers.user_id', '=', 'audio_posts.user_id')
                     ->where('feeds.type', 'audio');
            })
            ->leftJoin('video_posts', function ($join) {
                $join->on('followers.user_id', '=', 'video_posts.user_id')
                     ->where('feeds.type', 'video');
            })
            ->leftJoin('posts', function ($join) {
                $join->on('followers.user_id', '=', 'posts.user_id')
                     ->where('feeds.type', 'post');
            })
            ->sortBy('feeds.id','DESC')
            ->get();
        $result = new FeedCollection($feeds);

        return response()->json($result);
    }
}
