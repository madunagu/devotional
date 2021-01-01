<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class VideoPost extends Model
{
    use SearchableTrait, SoftDeletes;
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'video_posts.name' => 10,
            'video_posts.description' => 5,
            'video_posts.full_text' => 2,
        ],
        'joins' => [
           
        ],
    ];


    protected $fillable = [
        'name',
        'src_url',
        'full_text',
        'description',
        'author_id',
        'uploader_id',
        'size',
        'length',
        'language',
    ];

    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag','taggable');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'uploader_id');
    }

    public function addresses()
    {
        return $this->morphToMany('App\Address', 'addressable', 'addressables');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function infoCard()
    {
        return $this->morphMany(InfoCard::class, 'info_cardable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
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
