<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    function users(){
        return $this->hasMany(User::class);
    }

    function cities(){
        return $this->hasMany(City::class);
    }

    function transprices(){
        return $this->hasMany(Transprice::class);
    }

    protected $fillable  = [
        'country',
        'flag',
    ];
}
