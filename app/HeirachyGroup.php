<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeirachyGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','description','user_id'];

    public function heirachies()
    {
        return $this->hasMany('App\heirachy');
    }
}
