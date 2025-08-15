<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieTheater extends Model
{
    protected $table = 'movie_theaters';
    public $timestamps = false;

    protected $fillable = ['name_theater', 'address_theater', 'image_theater', 'city_id', 'company_id', 'status_theater'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function company()
    {
        return $this->belongsTo(TheaterCompany::class, 'company_id');
    }

    public function rooms()
    {
        return $this->hasMany(TheaterRoom::class, 'theater_id');
    }
}
