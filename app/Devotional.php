<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class Devotional extends Model
{
    use SearchableTrait, SoftDeletes;

    protected $fillable = ['title', 'opening_prayer', 'closing_prayer', 'body', 'memory_verse', 'day'];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function devotees()
    {
        return $this->belongsToMany('App\User', 'devotional_user');
    }

    public function profileMedia()
    {
        return $this->morphOne('App\ProfileMedia', 'profile_mediable');
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

    public function churches()
    {
        return $this->morphToMany('App\Church', 'churchable', 'churchables');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uploader_id');
    }
}
