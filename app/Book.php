<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = ['user_id', 'apartment_id', 'book_start', 'book_end'];

    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
