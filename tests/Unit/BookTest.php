<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase {
    
    use RefreshDatabase;

    /**
     * A author id is recorded
     *
     * @test
     */
    public function a_author_id_is_recorded() {
        Book::create(['title'=>"titke", 'author_id' => 1]);
        $this->assertCount(1, Book::all());
    }

}
