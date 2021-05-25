<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->unsignedBigInteger('photo_id')->nullable(false);
            $table->foreign('user_id')->references('id')->on('users');
            $table->unique(['user_id', 'photo_id']);
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
        Schema::dropIfExists('favourites');
    }
}
