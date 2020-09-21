<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Author extends Model {

    protected $guarded = [];
    protected $dates = ['dob'];

    public function setDobAttribute($value) {
        $this->attributes['dob'] = Carbon::parse($value);
    }

}
