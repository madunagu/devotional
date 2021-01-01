<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'name',
        'src_url',
        'full_text',
        'description',
        'author_id',
        'uploader_id',
        'church_id',
        'size',
        'length',
        'profile_media_id',
        'language',
        'address_id',
        'view_group_id',
        'comment_group_id',
        'like_group_id',
        'object_meta_id',
    ];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function tags()
    {
        return $this->morphToMany('App\Tag','taggable');
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

    public function churches()
    {
        return $this->morphToMany('App\Church', 'churchable');
    }
}
