<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }
    public function addresses()
    {
        return $this->morphToMany('App\Address', 'addressable', 'addressables');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }
    public function views()
    {
        return $this->morphMany('App\View', 'viewable');
    }

    public function churches()
    {
        return $this->morphToMany('App\Church', 'churchable');
    }
}
