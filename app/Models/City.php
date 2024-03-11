<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    function country(){
        return $this->belongsTo(Country::class);
    }

    protected $fillable  = [
        'city',
        'country_id',
    ];
}
