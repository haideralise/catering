<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class User extends Eloquent

{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [

        'name',
        'email',
        'password',
        'image',
        'type',
        'address'
    ];
    protected $hidden = ['password'];
    public $timestamps = false;

}
