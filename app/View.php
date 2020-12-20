<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'user_id',
        'viewable_id',
        'viewable_type'
    ];
}
