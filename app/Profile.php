<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'callrail', 'facebook'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
