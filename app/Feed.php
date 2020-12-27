<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    public function parentable()
    {
        return $this->morphTo('parentable');
    }

    public function poster()
    {
        return $this->morphTo('postable');
    }
}
