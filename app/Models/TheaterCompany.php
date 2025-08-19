<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheaterCompany extends Model
{
    protected $table = 'theater_companies';
    public $timestamps = false;

    protected $fillable = ['name_company', 'logo_company', 'status_company'];

    public function theaters()
    {
        return $this->hasMany(MovieTheater::class, 'company_id');
    }
}
