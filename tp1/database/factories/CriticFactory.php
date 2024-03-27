<?php

namespace Database\Factories;

use App\Models\Film;
use Database\Seeders\FilmSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\Actor as Actor;
use App\Models\User;

class CriticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();

        return [
            'user_id'=> User::inRandomOrder()->first()->id,
            'film_id' => Film::inRandomOrder()->first()->id,
            'score' => $this->faker->randomFloat(1,0,10),
            'comment'=> $this->faker->text(100)
        ];
    }
}
