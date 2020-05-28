<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id', 'text'
    ];
   
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }    
}
