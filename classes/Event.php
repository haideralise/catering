<?php

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;

class Event extends Eloquent

{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'gathering_type',
        'number_of_peoples',
        'number_of_waiters',
        'separate_male_female',
        'venue',
        'user_id',
        'status',
        'starts_at',
        'hours'
    ];
    public $timestamps = false;

}
