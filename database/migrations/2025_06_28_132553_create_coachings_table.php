<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coachings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('coach_id')->nullable();
            $table->unsignedBigInteger('demande_id')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();


            $table->integer('duree')->nullable(); // Use 'time' or 'integer' for duration, not 'dateTime'
            $table->dateTime('date_coaching')->nullable();
            $table->text('commentaires')->nullable();
            $table->enum('status', ['accepted', 'done'])->default('accepted'); // Statut de la demande              $table->timestamps();
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('set null');
            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coach_id')->references('id')->on('users')->onDelete('cascade');


        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coachings');
    }
};
