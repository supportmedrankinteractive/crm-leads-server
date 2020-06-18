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
        'user_id', 'callrail', 'facebook', 'company_name'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
   
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }    
}
