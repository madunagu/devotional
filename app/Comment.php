<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'comment',
        'parent_id',
        'user_id',
    ];

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    // public function posts()
    // {
    //     return $this->morphedByMany(Post::class, 'taggable');
    // }
}
