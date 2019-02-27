<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    protected $fillable = ['name','alternate_name','parent_id','leader_id','user_id','address_id','profile_media_id','slogan','description'];
}
