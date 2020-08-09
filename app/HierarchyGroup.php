<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HierarchyGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','user_id'];

    public function heirarchies()
    {
        return $this->hasMany('App\Hierarchy');
    }
}
