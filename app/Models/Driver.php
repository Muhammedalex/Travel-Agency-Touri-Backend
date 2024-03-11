<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Driver extends Model
{
    use HasFactory;

    function transportation(){
        return $this->belongsTo(Transportation::class);
    }

    function cities(){
        return $this->belongsTo(City::class);
    }

    function photoDrivers(){
        return $this->hasMany(PhotoDriver::class);
    }



    protected $fillable  = [
        'name',
        'mobile',
        'car_model',
        'num_of_seats',
        'driver_rate',
        'driver_price',
        'note',
        'share',
        'picture',
        'city_id',
        'transportation_id',
    ];

    public function getPictureUrlAttribute()
    {
        // get url
        return Storage::disk('imagesfp')->url($this->picture);
    }
}
