<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;
use App\Book;
use App\Reservation;

class BookReservationTest extends TestCase {

    use RefreshDatabase;

    /**
     * 
     *
     * @test
     */
    public function a_book_can_be_checkout() {

        $book = factory(Book::class)->create();
        $user = factory(Author::class)->create();

        $book->checkout($user);

        $reservation = Reservation::first();
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertEquals(now(), $reservation->checkout_at);
    }

    /**
     * 
     *
     * @test
     */
    public function a_book_can_be_returned() {
        $book = factory(Book::class)->create();
        $user = factory(Author::class)->create();
        $book->checkout($user);

        $book->checkIn($user);

        $reservation = Reservation::first();
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNotNull($reservation->checkin_at);
        $this->assertEquals(now(), $reservation->checkin_at);
    }

    /**
     * if not checkout throw exception
     *
     * @test
     */
    public function if_not_checkout_throw_exception() {
        
        $this->expectException(\Exception::class);
        $book = factory(Book::class)->create();
        $user = factory(Author::class)->create();
        
        $book->checkIn($user);
    }

    /**
     * user can checkout twice
     *
     * @test
     */
    public function a_book_can_be_checkout_twice() {
        $book = factory(Book::class)->create();
        $user = factory(Author::class)->create();

        $book->checkout($user);

        $book->checkin($user);

        $book->checkout($user);


        $reservation = Reservation::find(2);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNull($reservation->checkin_at);
        $this->assertEquals(now(), $reservation->checkout_at);

        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertNotNull($reservation->fresh()->checkin_at);
        $this->assertEquals(now(), $reservation->fresh()->checkin_at);
    }

}
