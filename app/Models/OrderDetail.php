<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    public $timestamps = false;

    protected $fillable = ['seat_id', 'order_id'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function seat()
    {
        return $this->belongsTo(ShowSeat::class, 'seat_id');
    }
}
