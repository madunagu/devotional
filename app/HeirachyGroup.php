<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeirachyGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','name','description','user_id'];
}
