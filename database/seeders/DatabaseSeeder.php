<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookReview;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);

        User::factory(5)->create();
        $authors = Author::factory(5)->create();
        // TODO: $authors->random() придумать чтобы были разные авторы от 1 до 3
        Book::factory(20)->hasAttached($authors->random())->create();
        BookReview::factory(40)->create();
    }
}
