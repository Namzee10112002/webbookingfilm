<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowSeat extends Model
{
    protected $table = 'show_seats';
    public $timestamps = false;

    protected $fillable = ['show_id', 'seat_number', 'status_seat'];

    public function show()
    {
        return $this->belongsTo(MovieShow::class, 'show_id');
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'seat_id');
    }
}
