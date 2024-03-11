<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transprice extends Model
{
    use HasFactory;

    function country(){
        return $this->belongsTo(Country::class);
    }

    function transportation(){
        return $this->belongsTo(Transportation::class);
    }


    protected $fillable  = [
        'price',
        'transportation_id',
        'country_id',
    ];
}
