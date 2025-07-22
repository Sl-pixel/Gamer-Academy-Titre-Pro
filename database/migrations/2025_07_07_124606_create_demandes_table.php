<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID de l'utilisateur qui a fait la demande
            $table->unsignedBigInteger('coach_id'); // ID de l'utilisateur qui a recu la demande
            $table->unsignedBigInteger('game_id'); // ID du jeu pour lequel la demande est faite
            $table->string('discord')->nullable(); // ID du jeu pour lequel la demande est faite
            $table->integer('duree')->nullable(); // Use 'time' or 'integer' for duration, not 'dateTime'
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Statut de la demande
            $table->text('message'); //explic
            
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('coach_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandes');
    }
};
