<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccommodationType extends Model
{
    use HasFactory;

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class, 'type', 'type');
    }

    protected $fillable  = [
       'type',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($accommodationType) {
            // Update related accommodations when the name is updated
            $accommodationType->accommodations()->update(['type' => $accommodationType->type]);
        });
    }
}
