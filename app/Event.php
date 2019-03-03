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
            'addresses' => ['address_id','addresses.id'],
            'profile_media' => ['profile_media_id','profile_media.id'],
            'churches' => ['church_id','churches.id'],
        ],
     ];

    protected $fillable = ['name','church_id','starting_at','ending_at','address_id','heirachy_group_id','profile_media_id','user_id'];

    public function addresses()
    {
        return $this->hasOne('App\Address');
    }

    public function profileMedia()
    {
        return $this->hasOne('App\ProfileMedia');
    }

    public function church()
    {
        return $this->hasOne('App\Church');
    }

    public function heirachyGroup(){
        return $this->hasOne('App\HeirachyGroup');
    }
}
