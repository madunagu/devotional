<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public  function  profileMedia(){
        return $this->belongsTo('App\ProfileMedia','profile_media_id');
    }
}
