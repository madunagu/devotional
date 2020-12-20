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
        'joins' => [
            'addresses' => ['address_id', 'addresses.id'],
            'profile_media' => ['profile_media_id', 'profile_media.id'],
            'churches' => ['church_id', 'churches.id'],
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

    public function profileMedia()
    {
        return $this->morphOne('App\ProfileMedia', 'profile_mediable');
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
        return $this->morphToMany('App\Address','addressable','addressables');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function infoCards()
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
