<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Author;

class AuthorTest extends TestCase {

    use RefreshDatabase;

    /**
     * A author can be cerated
     *
     * @test
     */
    public function a_author_can_be_created() {
        $this->withoutExceptionHandling();
        $this->post('/authors', [
            'name' => "ANes nAme",
            'dob' => '05/14/2010'
        ]);

        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertInstanceOf(\Carbon\Carbon::class, $author->dob);
        $this->assertEquals('2010/05/14', $author->dob->format('Y/m/d'));
    }

    /**
     * A author name is required
     *
     * @test
     */
    public function a_author_name_is_required() {
        $response = $this->post('/authors', [
            'name' => "",
            'dob' => '05/14/2010'
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * A author dob is required
     *
     * @test
     */
    public function a_author_dob_is_required() {
        $response = $this->post('/authors', [
            'name' => "Name Rddu",
            'dob' => ''
        ]);
        $response->assertSessionHasErrors('dob');
    }

}
