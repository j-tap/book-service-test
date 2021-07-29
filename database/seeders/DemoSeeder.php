<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Eloquent\Factories\Sequence;
use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookReview;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)->create();

        $authors = Author::factory(5)->create();
        $authors->each(function ($author)
        {
            $books = Book::factory(rand(1, 5))
            ->hasAttached($author)
            ->create();

            $books->each(function ($book)
            {
                BookReview::factory(rand(1, 5))
                ->state([
                    'book_id' => $book->id,
                ])
                ->create();
            });
        });
    }
}
