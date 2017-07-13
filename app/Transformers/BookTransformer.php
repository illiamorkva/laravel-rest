<?php

namespace App\Transformers;

use App\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    public function transform(Book $book)
    {
        return [
            'name' => $book->name,
            'price' => (int)$book->price,
            'user' =>[
                'username' => $book->user->username,
                'email' => $book->user->email,
            ],
        ];
    }
}