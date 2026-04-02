<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $author = Author::inRandomOrder()->first();
        return [
            'title'     => $this->faker->sentence(3),
            'pages'     => $this->faker->numberBetween(100, 1000),
            'price'     => $this->faker->randomFloat(2, 10, 100),
            'author_id' => $author->id,
        ];
    }
}
