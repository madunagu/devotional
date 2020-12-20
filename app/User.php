<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'gender'
    ];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'users.name' => 1,
        ],

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function following()
    {
        return $this->belongsToMany('App\User', 'user_followers', 'follower_id', 'user_id')->whereKeyNot(1);
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_followers', 'user_id', 'follower_id');
    }

    public  function feeds()
    {
        return $this->hasMany('App\Feed', 'poster_id');
    }

    public function infoCard()
    {
        return $this->morphMany(InfoCard::class, 'info_cardable');
    }

    public function profileMedia()
    {
        return $this->morphOne('App\ProfileMedia', 'profile_mediable');
    }

}
