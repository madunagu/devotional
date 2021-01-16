<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class AudioPost extends Model
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
            'audio_posts.name' => 10,
            'audio_posts.description' => 5,
            'audio_posts.full_text' => 2,
        ],
        'joins' => [],
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

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function infoCards()
    {
        return $this->morphMany('App/InfoCard', 'info_cardable');
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
