<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devotional extends Model
{
    protected $fillable = ['title', 'opening_prayer', 'closing_prayer', 'body', 'memory_verse', 'day'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function poster()
    {
        return $this->morphTo('poster');
    }

    public function views()
    {
        return $this->morphMany('App\View', 'viewable');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uploader_id');
    }
}
