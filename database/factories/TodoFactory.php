<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $author = \App\Models\User::inRandomOrder()->first();

        return [
            'author_id' => $author->id,
            'title' => $this->faker->word(),
        ];
    }
}
