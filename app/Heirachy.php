<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Heirachy extends Model
{
    use SoftDeletes;
    protected $fillable = ['heirachy_group_id','rank','position_name','position_slang','person_name','user_id'];
}
