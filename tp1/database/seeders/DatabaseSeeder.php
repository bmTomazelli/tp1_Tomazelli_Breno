<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            LanguageSeeder::class,
            FilmSeeder::class,
            UserSeeder::class,
            ActorSeeder::class,
            Actor_Film_Seeder::class,
            CriticSeeder::class
        ]);

    }
}
