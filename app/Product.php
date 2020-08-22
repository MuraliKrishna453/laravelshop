<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    //

    public function owner() {
        return $this->belongsTo(User::class, 'created_at');
    }

}
