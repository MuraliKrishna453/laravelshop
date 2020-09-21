<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;
use App\Book;
use App\User;
use App\Reservation;

class BookReservationTest extends TestCase {

    use RefreshDatabase;

    /**
     * A book can be checkout
     *
     * @test
     */
    public function a_book_can_be_checked_out_by_signedIn_user() {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $this->be($user)
                ->post('checkout/' . $book->id);

        $reservation = Reservation::first();
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertEquals(now(), $reservation->checkout_at);
    }

    /**
     * A book can be checkout by only signed in user
     *
     * @test
     */
    public function only_signedIn_user_can_checked_out_book() {
//        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $this->post('checkout/' . $book->id)
                ->assertRedirect('/login');


        $this->assertCount(0, Reservation::all());
    }

    /**
     * only real book can be checkout
     *
     * @test
     */
    public function only_real_book_can_be_checked() {
//        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $this->be($user)->post('checkout/122')
                ->assertStatus(404);


        $this->assertCount(0, Reservation::all());
    }

    /**
     * A book can be checkin
     *
     * @test
     */
    public function a_book_can_be_checked_in_by_signedIn_user() {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $this->be($user)
                ->post('checkout/' . $book->id);


        $this->be($user)
                ->post('checkin/' . $book->id);

        $reservation = Reservation::first();
        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, $reservation->user_id);
        $this->assertEquals($book->id, $reservation->book_id);
        $this->assertEquals(now(), $reservation->checkin_at);
    }

    /**
     * A book cannot be checkin without checkout
     *
     * @test
     */
    public function a_book_cannot_checked_without_checkout() {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();
        $this->be($user)
                ->post('checkin/' . $book->id)
                ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }

}
