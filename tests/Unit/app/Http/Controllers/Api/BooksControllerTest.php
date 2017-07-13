<?php

namespace Tests\Unit\app\Http\Controllers\Api;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class BooksControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testIndexMethodReturnsAllBooks()
    {
        $user = factory(User::class)->create();

        $books = factory(Book::class, 2)->create(['user_id' => $user->id]);

        $this
            ->get(route('books.index'))
            ->assertStatus(200);

        foreach($books as $book) {
            $this
                ->get(route('books.index'))
                ->assertJson([
                'name' =>$book->name,
                'price' => $book->price,
            ]);
        }
    }

    public function testShowMethodReturnsParticularBook()
    {
        $user = factory(User::class)->create();

        $book = factory(Book::class)->create(['user_id' => $user->id]);

        $this
            ->get(route('books.show',[$book->id]))
            ->assertStatus(200);
    }
}
