<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->year('release_year')->nullable();
            $table->unsignedBigInteger('language_id');
            $table->unsignedTinyInteger('original_language_id')->nullable()->default(null);
            $table->unsignedTinyInteger('rental_duration')->default(3);
            $table->decimal('rental_rate',4,2)->default(4.99);
            $table->unsignedSmallInteger('length')->nullable()->default(null);
            $table->decimal('replacement_cost',5,2)->default(19.99);
            $table->enum('rating', ['G', 'PG','PG-13','R','NC-17'])->nullable()->default('G');
            $table->set('special_features',['Trailers','Commentaries','Deleted Scenes','Behind the Scenes'])->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('films');
    }
}
