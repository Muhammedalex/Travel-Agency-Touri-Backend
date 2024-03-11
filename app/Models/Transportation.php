<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    function transprices(){
        return $this->hasMany(Transprice::class);
    }
    function drivers(){
        return $this->hasMany(Driver::class);
    }
    protected $fillable  = [
        'type',
    ];
}
