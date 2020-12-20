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
        'user_',
    ];

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
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
