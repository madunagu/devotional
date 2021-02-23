<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use QCod\ImageUp\HasImageUploads;

class Image extends Model
{
    use HasImageUploads;

    protected $autoUploadImages = false;

    protected $fillable = [
        'full',
        'large',
        'medium',
        'small',
        'avatar',
        'user_id',
    ];

    protected static $imageFields = [
        'full' => [
            'disk' => 'public',
            'path' => 'images/full',
            // 'rules' => 'image|max:2000',
            // 'auto_upload' => false,
            'file_input' => 'photo',
            // validation rules when uploading image
            'rules' => 'image|max:2000',
        ],
        'large' => [
            'width' => 500,
            'height' => 500,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/large',
            'file_input' => 'photo',
        ],
        'medium' => [
            'width' => 200,
            'height' => 200,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/medium',
            'file_input' => 'photo',
        ],
        'small' => [
            'width' => 100,
            'height' => 100,
            'crop' => true,
            'disk' => 'public',
            'path' => 'images/small',
            'file_input' => 'photo',
        ],
    ];
}
