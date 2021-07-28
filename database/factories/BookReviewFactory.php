<?php

namespace Database\Factories;

use App\Models\BookReview;
use App\Models\Book;
// use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // TODO: сделать несколько разных отзывов
            'book_id' => Book::factory(),
            // 'user_id' => User::factory(),
            'text' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
