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
        ],
        'joins' => [
            'addresses' => ['address_id','addresses.id'],
            'profile_media' => ['profile_media_id','profile_media.id'],
        ],
     ];

    protected $fillable = ['name','alternate_name','parent_id','leader_id','user_id','address_id','profile_media_id','slogan','description','heirachy_group_id'];

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function profileMedia()
    {
        return $this->hasOne('App\ProfileMedia');
    }
    
    public function heirachyGroup()
    {
        return $this->hasOne('App\HeirachyGroup');
    }
}
