<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Author;

class AuthorTest extends TestCase {

    use RefreshDatabase;

    /**
     * name is required to create author
     *
     * @test
     */
    public function a_name_is_required() {
        $response = Author::firstOrCreate(['name' => "Suub"]);
        
        $this->assertCount(1, Author::all());
    }

}
