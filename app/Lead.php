<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'profile_id', 'platform_id', 'content'
    ];

    public function follow_ups()
    {
        return $this->hasMany(FollowUp::class, 'lead_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }    
}
