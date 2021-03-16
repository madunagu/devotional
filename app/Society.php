<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class Society extends Model
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
            'societies.name' => 10,
            'societies.description' => 5,
        ],
        'joins' => [
        ],
    ];

    protected $fillable = [
        'name', 'parent_id', 'closed', 'user_id', 'description',
    ];

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable', 'imageables');
    }

     
    public function churches()
    {
        return $this->morphToMany('App\Church', 'churchable');
    }

    public function hierarchies()
    {
        return $this->morphToMany('App\Hierarchy', 'hierarchyable');
    }

    public function addresses()
    {
        return $this->morphToMany('App\Address','addressable','addressables');
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
}
