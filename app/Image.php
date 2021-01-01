<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use QCod\ImageUp\HasImageUploads;

class Image extends Model
{
    use HasImageUploads;

    protected $fillable = [
        'full_url',
        'large_url',
        'medium_url',
        'small_url',
        'avatar_url',
        'user_id',
    ];

    protected static $imageFields = [
        'full_url' => [
            'disk' => 'public',
            'path' => 'images/full',
            'rules' => 'image|max:2000',
            'auto_upload' => false,
            'file_input' => 'photo',
            // validation rules when uploading image
            'rules' => 'image|max:2000',
        ],
        'large_url' => [
            'width' => 500,
            'height' => 500,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/large',
            'file_input' => 'photo',
        ],
        'medium_url' => [
            'width' => 200,
            'height' => 200,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/medium',
            'file_input' => 'photo',
        ],
        'small_url' => [
            'width' => 100,
            'height' => 100,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/small',
            'file_input' => 'photo',
        ],
        'avatar_url' => [
            'width' => 50,
            'height' => 50,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/avatar',
            'file_input' => 'photo',
        ],
    ];
}
