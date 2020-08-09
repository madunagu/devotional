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
            'addresses' => ['churches.address_id','addresses.id'],
            'profile_media' => ['churches.profile_media_id','profile_media.id'],
            'users' => ['churches.user_id','users.id'],
        ],
     ];

    protected $fillable = ['name','alternate_name','parent_id','leader_id','user_id','address_id','profile_media_id','slogan','description','hierarchy_group_id'];

    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    public function profileMedia()
    {
        return $this->belongsTo('App\ProfileMedia');
    }

    public function hierarchyGroup()
    {
        return $this->belongsTo('App\HierarchyGroup');
    }

    public function leader()
    {
        return $this->belongsTo('App\User', 'leader_id');
    }
}
