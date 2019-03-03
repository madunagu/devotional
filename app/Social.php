<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social extends Model
{
    use SoftDeletes;

    protected $fillable = ['facebook_url','twitter_url','instagram_url','youtube_url','rss_url','snapchat_url','website_url'];
}
