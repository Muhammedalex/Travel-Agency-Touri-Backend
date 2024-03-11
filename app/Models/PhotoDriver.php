<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PhotoDriver extends Model
{
    use HasFactory;

    function driver(){
        return $this->belongsTo(Driver::class);
    }

    protected $fillable  = [
        'driver_id',
        'car_photo',
    ];

    public function getCarPhotoUrlAttribute()
    {
        // get url
        return Storage::disk('imagesfp')->url($this->car_photo);
    }
}
