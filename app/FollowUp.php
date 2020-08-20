<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lead_id', 'text', 'date_at', 'order'
    ];
   
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }    
    public function setDateAtAttribute($value) 
    { 
        $this->attributes['date_at'] = Carbon::parse($value)->format('Y-m-d'); 
    }    
    // public function getDateAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('d-m-Y');
    // }    
}
