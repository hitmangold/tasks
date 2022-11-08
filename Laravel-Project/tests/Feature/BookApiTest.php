<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookApiTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected $user;
    protected $author;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->author = Author::factory()->withUser($this->user->id)->create();
        $this->actingAs($this->user, 'sanctum');
    }
    public function test_can_get_book()
    {
        $this->withExceptionHandling();
        $this->get(route('api.getBooks'))->assertStatus(200);
    }
    public function test_can_create_book()
    {
        $formData = [
            'title' => 'Example title',
            'price' => '2000',
            'qty' => '20'
        ];
        $this->withExceptionHandling();
        $this->post(route('api.createBook'), $formData)->assertStatus(200);
    }
    public function test_can_delete_book()
    {
        $formData = [
            'title' => 'Example title',
            'price' => '2000',
            'qty' => '20'
        ];
        $book = $this->post(route('api.createBook'), $formData)->assertStatus(200);
        $formData = ['id' => $book['id']];
        $this->withExceptionHandling();
        $this->post(route('api.deleteBook'), $formData)->assertStatus(200);
    }
    public function test_cant_delete_book()
    {
        $formData = [
            'title' => 'Example title',
            'price' => '2000',
            'qty' => '20'
        ];
        $book = $this->post(route('api.createBook'), $formData)->assertStatus(200);
        $formData = ['id' => ''];
        $this->withExceptionHandling();
        $this->post(route('api.deleteBook'), $formData)->assertStatus(400);
    }
    public function test_cant_create_book()
    {
        $formData = [
            'title' => '',
            'price' => '',
            'qty' => ''
        ];
        $this->withExceptionHandling();
        $this->book = $this->post(route('api.createBook'), $formData)->assertStatus(400);
    }
}
