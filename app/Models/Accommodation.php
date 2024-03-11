<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Accommodation extends Model
{
    use HasFactory;
    public function accommodationType()
    {
        return $this->belongsTo(AccommodationType::class, 'type', 'type');
    }

    protected $fillable  = [
        'name',
        'rate',
        'mobile',
        'address',
        'email',
        'share',
        'note',
        'cover',
        'video',
        'type',
        'city_id',
     ];

     public function getCoverUrlAttribute()
    {
        // get url
        return Storage::disk('imagesfp')->url($this->cover);
    }

    public static function getAllWithCoverUrls()
    {
        return static::with('accommodationType')->get()->transform(function ($accommodation) {
            $accommodation->cover = $accommodation->cover_url;
            return $accommodation;
        });
    }
}
