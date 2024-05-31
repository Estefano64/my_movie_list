<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'release_year',
        'synopsis',
        'cover_image',
        'watched'
    ];

    /**
     * The user that owns the movie.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

