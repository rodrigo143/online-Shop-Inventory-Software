<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function purchase()
    {
        return $this->hasMany('App\Purchase');
    }
}
