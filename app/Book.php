<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Reservation;

class Book extends Model {

    public $guarded = [];

    public function path() {
        return 'books/' . $this->id;
    }

    public function setAuthorIdAttribute($value) {
        $this->attributes['author_id'] = Author::firstOrCreate(['name' => $value])->id;
    }

    public function checkout($user) {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checkout_at' => now()
        ]);
    }

    public function checkin($user) {
        $reservation = $this->reservations()
                ->where('user_id', $user->id)
                ->whereNotNull('checkout_at')
                ->whereNull('checkin_at')
                ->first();
        if (is_null($reservation)) {
            throw new \Exception();
        }
        $reservation->update(['checkin_at' => now()]);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }

}
