<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieComment extends Model
{
    protected $table = 'movie_comments';
    public $timestamps = false;

    protected $fillable = ['user_id', 'content_comment', 'date_comment', 'movie_id', 'status_comment'];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
