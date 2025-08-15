<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'phone', 'role', 'status', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at'];

    public function comments()
    {
        return $this->hasMany(MovieComment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(MovieLike::class, 'user_id');
    }

    public function rates()
    {
        return $this->hasMany(MovieRate::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
