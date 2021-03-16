<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hierarchy extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['rank','position_name','position_slang','person_name','user_id'];
}
