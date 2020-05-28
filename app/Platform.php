<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
}
