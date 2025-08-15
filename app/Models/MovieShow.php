<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieShow extends Model
{
    protected $table = 'movie_shows';
    public $timestamps = false;

    protected $fillable = ['movie_id', 'room_id', 'time_start', 'time_end', 'price', 'status_show'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function room()
    {
        return $this->belongsTo(TheaterRoom::class, 'room_id');
    }

    public function seats()
    {
        return $this->hasMany(ShowSeat::class, 'show_id');
    }
}
