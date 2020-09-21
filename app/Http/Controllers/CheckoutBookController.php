<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class CheckoutBookController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Book $book) {
        $book->checkout(auth()->user());
    }
    
    public function checkin(Book $book) {
        try{
            $book->checkin(auth()->user());
        }catch(\Exception $e){
            return response([],404);
        }
    }

}
