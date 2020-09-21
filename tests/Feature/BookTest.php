<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Book;
use App\Author;

class BookTest extends TestCase {

    use RefreshDatabase;

    /**
     * A book can be added to library
     *
     * @test
     */
    public function a_book_can_be_added_to_library() {

        $response = $this->post('/books', [
            'title' => "New Book",
            'author_id' => "Redady"
        ]);
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /**
     * title is required
     *
     * @test
     */
    public function a_title_is_required() {
//        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => "",
            'author_id' => "Redady"
        ]);
//        $response->assertStatus(422);
//        $response->assertSee("The title is required");
        $response->assertSessionHasErrors('title');
    }

    /**
     * title is required
     *
     * @test
     */
    public function a_author_is_required() {
//        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => "New Book",
            'author_id' => ""
        ]);
//        $response->assertStatus(422);
//        $response->assertSee("The title is required");
        $response->assertSessionHasErrors('author_id');
    }

    /**
     * A book can be added to library
     *
     * @test
     */
    public function a_book_can_be_updated() {

//        $this->withoutExceptionHandling();


        $this->post('/books', [
            'title' => "New Book",
            'author_id' => "Redady"
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => "Uopdated Book",
            'author_id'=>1
        ]);

        $this->assertEquals("Uopdated Book", $book->fresh()->title);
        $response->assertRedirect($book->path());
    }

    /**
     * A book can be deleted
     *
     * @test
     */
    public function a_book_can_deleted() {
//        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => "New Book",
            'author_id' => "Redady"
        ]);
        $this->assertCount(1, Book::all());

        $book = Book::first();

        $response = $this->delete('books/' . $book->id);
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    /**
     * a author is automatically added 
     *
     * @test
     */
    public function a_new_author_can_be_added_automatically() {

        $this->post('/books', [
            'title' => "New Book",
            'author_id' => "Redady"
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($book->author_id, $author->id);
        $this->assertCount(1, Author::all());
    }

}
