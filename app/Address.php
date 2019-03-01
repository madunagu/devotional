<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Nicolaslopezj\Searchable\SearchableTrait;

class Address extends Model
{
    use SearchableTrait, SoftDeletes;

    protected $fillable = ['address1','address2','country','state','city','postal_code','name','longitude','lattitude'];
}
