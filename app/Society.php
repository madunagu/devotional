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
            'profile_media' => ['profile_media_id','profile_media.id'],
            'churches' => ['church_id','churches.id'],
        ],
     ];

    protected $fillable = ['name','church_id','parent_id','closed','profile_media_id','user_id','heirachy_group_id','description'];

    public function profileMedia()
    {
        return $this->belongsTo('App\ProfileMedia');
    }

    public function church()
    {
        return $this->belongsTo('App\Church');
    }

    public function heirachyGroup()
    {
        return $this->belongsTo('App\HeirachyGroup');
    }
}
