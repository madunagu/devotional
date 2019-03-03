<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfileMedia extends Model
{
    use SoftDeletes;

    protected $fillable = ['logo_url','profile_image_url','background_image_url','color_choice','user_id'];
}
