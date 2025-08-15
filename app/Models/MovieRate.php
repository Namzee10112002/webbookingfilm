<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieRate extends Model
{
    protected $table = 'movie_rates';
    public $timestamps = false;

    protected $fillable = ['user_id', 'movie_id', 'user_rate'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
