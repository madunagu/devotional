<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class AudioPost extends Model
{
    use SearchableTrait, SoftDeletes;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'audio_posts.name' => 10,
            'audio_posts.description' => 5,
            'audio_posts.full_text' => 2,
        ],
        'joins' => [
            'addresses' => ['address_id','addresses.id'],
            'profile_media' => ['profile_media_id','profile_media.id'],
            'churches' => ['church_id','churches.id'],
        ],
     ];

    protected $fillable = ['name','src_url','full_text','description','author_id','uploader_id','church_id','size','length','profile_media_id', 'language','address_id'];

    public function profileMedia()
    {
        return $this->belongsTo('App\ProfileMedia');
    }

    public function church()
    {
        return $this->belongsTo('App\Church');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }
}
