<?php

namespace Database\Factories;

use App\Models\Film;
use Database\Seeders\FilmSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\Actor as Actor;

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
            'user_id'=> $this->random_int(Actor::pluck('id')),
            'film_id' => $this->random_int(Film::pluck('id')),
            'score' => $this->random_int(),
            'comment'=> $this->text(100),
            'created_at'=>$this->$faker->date(),
            'updated_at'=>$this->$faker->date(),
        ];
    }
}
