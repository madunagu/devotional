<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class HierarchyGroup extends Model
{
    use SearchableTrait, SoftDeletes;

    protected $searchable = [
        'columns' => [
            'hierarchy_groups.name' => 10,
            'hierarchy_groups.description' => 5,
        ],
        'joins' => [],
    ];

    protected $fillable = ['name', 'description', 'user_id'];

    public function heirarchies()
    {
        return $this->hasMany('App\Hierarchy');
    }
}
