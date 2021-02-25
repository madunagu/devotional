<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class Church extends Model
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
            'churches.name' => 10,
            'churches.alternate_name' => 5,
            'churches.slogan' => 2,
            'churches.description' => 1,
            'churches.parent_id' => 1,
            'churches.leader_id' => 1,
        ],
        // 'joins' => [
        //     'addresses' => ['churches.address_id', 'addresses.id'],
        //     'users' => ['churches.user_id', 'users.id'],
        // ],
    ];

    protected $fillable = [
        'name', 'alternate_name', 'parent_id', 'leader_id', 'user_id', 'slogan', 'description', 
      
    ];

    public function addresses()
    {
        return $this->morphToMany('App\Address','addressable');
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable', 'imageables');
    }

    public function hierarchyGroup()
    {
        return $this->belongsTo('App\HierarchyGroup');
    }

    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    public function infoCard()
    {
        return $this->morphMany(InfoCard::class, 'info_cardable');
    }

    public function churchable(){
        return $this->morphTo();
    }
        
    public function views()
    {
        return $this->morphMany('App\View', 'viewable');
    }

}
