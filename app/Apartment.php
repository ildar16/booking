<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = ['title', 'alias', 'price', 'rooms', 'description', 'img', 'comforts', 'status'];

//    public function comfort()
//    {
//        return $this->hasMany('App\Comfort');
//    }

    public function book()
    {
        return $this->hasMany('App\Book');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function getImgAttribute($value)
    {
        return json_decode($value);
    }

}
