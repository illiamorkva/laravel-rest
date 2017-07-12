<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BookTest extends TestCase
{
    //use DatabaseMigrations;

    public function testBooksCanBeDeleted()
    {
        $user = factory(User::class)->create();

        $book = $user->books()->create([
            'name' => 'Code Complete',
            'price' => 100
        ]);

        $book->delete();

        $this->assertDatabaseMissing('books', ['id' => 1, 'name' => 'Code Complete', 'price' => 100]);
    }

    public function testBooksCanBeCreated()
    {
        $user = factory(User::class)->create();

        $book = $user->books()->create([
            'name' => 'Code Complete',
            'price' => 100
        ]);

        $foundBook = Book::find(2);

        $this->assertEquals($foundBook->name, 'Code Complete');
        $this->assertEquals($foundBook->price, 100);

        $this->assertDatabaseHas('books', ['id' => 2, 'name' => 'Code Complete', 'price' => 100]);
    }
}
