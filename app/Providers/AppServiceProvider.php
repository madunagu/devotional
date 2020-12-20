<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'address' => 'App\Address',
            'audio' => 'App\AudioPost',
            'church' => 'App\Church',
            'comment' => 'App\Comment',
            'event' => 'App\Event',
            'info_card' => 'App\InfoCard',
            'like' => 'App\Like',
            'post' => 'App\Post',
            'society' => 'App\Society',
            'user' => 'App\User',
            'video' => 'App\VideoPost',
        ]);
        Schema::defaultStringLength(191);
    }
}
