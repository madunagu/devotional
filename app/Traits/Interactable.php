<?php

namespace App\Traits;

use App\Http\Controllers\AudioPostController;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SocietyController;
use App\Http\Controllers\VideoPostController;
use Illuminate\Database\Eloquent\Model;
use App\AudioPost;
use App\Post;
use App\Like;
use App\Church;
use App\Comment;
use App\Event;
use App\ProfileMedia;
use App\Society;
use App\VideoPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait Interactable
{
    public  $models = [
        AudioPostController::class => 'audio',
        ChurchController::class => 'church',
        CommentController::class => 'comment',
        EventController::class => 'event',
        SocietyController::class => 'society',
        VideoPostController::class => 'video',
    ];

    function saveRelated(array $data, Model $created = null): array
    {
        if (!empty($data['church_id'])) {
            $created->churches()->attach((int)$data['church_id']);
        }
        if (!empty($data['address_id'])) {
            $created->addresses()->attach((int)$data['address_id']);
        }
        if (!empty($data['profile_media_id'])) {
            // $created->profileMedia()->attach((int)$data['profile_media_id']);
            $media = ProfileMedia::findOrFail(1);
            $media->profileMediaable()->associate($created);
            // $created->profileMedia;
            // $media->save();
        }

        return $data;
    }

    public function like(Request $request)
    {

        $user_id = Auth::user()->id;
        $id = (int)$request->route('id');
        $type = $this->models[static::class];
        if ($like = Like::where('user_id', $user_id)->where('likeable_id', $id)->where('likeable_type', $type)->first()) {
            $like->delete();
            return response()->json(['data' => false], 200);
        } else {
            Like::create(
                [
                    'user_id' => $user_id,
                    'likeable_id' => $id,
                    'likeable_type' => $type
                ]
            );
            return response()->json(['data' => true], 200);
        }
    }
}
