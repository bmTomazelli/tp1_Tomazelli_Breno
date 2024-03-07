<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'login' => $this->faker->text(10),
            'password' => $this->faker->password(),
            'email' => $this->faker->unique()->safeEmail,
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
        ];
    }
}

