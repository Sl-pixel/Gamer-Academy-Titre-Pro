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
        Schema::create('revenues', function (Blueprint $table) {
            $table->id(); // Identifiant unique pour chaque entrée de revenu
            $table->unsignedBigInteger('coach_id'); // Identifiant de l'utilisateur (coach) associé au revenu
            $table->decimal('amount', 8, 2); // Montant du revenu
            $table->date('date'); // Date du revenu
            $table->timestamps(); // Colonnes created_at et updated_at

            // Définir une clé étrangère pour lier chaque revenu à un utilisateur
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
        Schema::dropIfExists('revenues');
    }
};
