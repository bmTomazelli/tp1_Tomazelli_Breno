<?php

namespace Database\Seeders;

use App\Models\Critic;
use App\Models\Film;
use Illuminate\Database\Seeder;

class CriticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Film::all()->each(function($film){
            for($i=0;$i<30;$i++){
                Critic::factory()->create(['film_id'=>$film->id]);
            }
        });
    }
}
