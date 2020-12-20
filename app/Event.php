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
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'events.name' => 10,
            'churches.name' => 5,
            'churches.slogan' => 2,
            'churches.description' => 1,
        ],
        'joins' => [
            'addresses' => ['address_id', 'addresses.id'],
            'profile_media' => ['profile_media_id', 'profile_media.id'],
            'churches' => ['church_id', 'churches.id'],
        ],
    ];

    protected $fillable = [
        'name', 'starting_at', 'ending_at','description', 'user_id',
    ];

    public function addresses()
    {
        return $this->morphToMany('App\Address', 'addressable', 'addressables');
    }

    public function attendees(){
        return $this->belongsToMany('App\User', 'event_user');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function profileMedia()
    {
        return $this->morphOne('App\ProfileMedia', 'profile_mediable');
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
        return $this->morphToMany('App\Church', 'churchable','churchables');
    }
    
    public function hierarchyGroups()
    {
        return $this->morphToMany('App\HierarchyGroup', 'hierarchyable','hierarchyables');
    }

        public function views()
    {
        return $this->morphMany('App\View', 'viewable');
    }
}
