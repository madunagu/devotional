<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class Event extends Model
{
    use SearchableTrait, SoftDeletes;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         ** Columns and their priority in search results.
         * Columns with higher values are more portant.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'events.name' => 10,
            'events.description' => 5,
        ],
        'joins' => [],
    ];

    protected $fillable = [
        'name', 'starting_at', 'ending_at', 'description', 'user_id',
    ];

    public function addresses()
    {
        return $this->morphToMany('App\Address', 'addressable', 'addressables');
    }

    public function hierarchies()
    {
        return $this->morphToMany('App\Hierarchy', 'hierarchyable');
    }

    public function poster()
    {
        return $this->morphTo('poster');
    }

    public function attendees()
    {
        return $this->belongsToMany('App\User', 'event_user');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function likes()
    {
        return $this->morphMany('App\Like', 'likeable');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable', 'imageables');
    }

    public function church()
    {
        return $this->belongsTo('App\Church');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function churches()
    {
        return $this->morphToMany('App\Church', 'churchable', 'churchables');
    }

    public function views()
    {
        return $this->morphMany('App\View', 'viewable');
    }
}
