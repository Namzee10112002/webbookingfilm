<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheaterRoom extends Model
{
    protected $table = 'theater_rooms';
    public $timestamps = false;

    protected $fillable = ['name_room', 'theater_id', 'seat', 'status_room'];

    public function theater()
    {
        return $this->belongsTo(MovieTheater::class, 'theater_id');
    }

    public function shows()
    {
        return $this->hasMany(MovieShow::class, 'room_id');
    }
}
