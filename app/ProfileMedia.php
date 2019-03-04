<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use QCod\ImageUp\HasImageUploads;

class ProfileMedia extends Model
{
    use SoftDeletes, HasImageUploads;

    protected $fillable = ['logo_url','profile_image_url','background_image_url','color_choice','user_id'];

    // assuming `users` table has 'cover', 'avatar' columns
    // mark all the columns as image fields
    protected static $imageFields = [
        'logo_url' => [
            // width to resize image after upload
            'width' => 200,

            // height to resize image after upload
            'height' => 100,

            // set true to crop image with the given width/height and you can also pass arr [x,y] coordinate for crop.
            'crop' => true,

            // what disk you want to upload, default config('imageup.upload_disk')
            'disk' => 'public',

            // a folder path on the above disk, default config('imageup.upload_directory')
            'path' => 'avatars',

            // placeholder image if image field is empty
            'placeholder' => '/images/avatar-placeholder.svg',

            // validation rules when uploading image
            'rules' => 'image|max:2000',

            // override global auto upload setting coming from config('imageup.auto_upload_images')
            'auto_upload' => false,

            // if request file is don't have same name, default will be the field name
            'file_input' => 'photo',

            // a hook that is triggered before the image is saved
            'before_save' => BlurFilter::class,

            // a hook that is triggered after the image is saved
            'after_save' => CreateWatermarkImage::class
        ],
        'background_image_url' => [
            'width' => 500,
            'height' => 500,
    'crop' => true,
        'disk' => 'public',
       // a folder path on the above disk, default config('imageup.upload_directory')
            'path' => 'background_images',
           'placeholder' => '/images/avatar-placeholder.svg',

        ],
        'profile_image_url' => [
            'width' => 500,
            'height' => 500,
    'crop' => true,
        'disk' => 'public',
       // a folder path on the above disk, default config('imageup.upload_directory')
            'path' => 'background_images',
           'placeholder' => '/images/avatar-placeholder.svg',

        ],

    ];
}
