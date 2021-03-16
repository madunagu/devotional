<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioSrc extends Model
{
    protected $fillable = [
        'refresh_rate',
        'bitrate', 'src', 'size', 'format', 'audio_post_id',
    ];
}
