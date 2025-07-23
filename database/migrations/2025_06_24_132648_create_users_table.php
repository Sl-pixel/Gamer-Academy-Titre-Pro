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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('discord')->unique()->nullable();
            $table->string('password');
            $table->string('notes')->nullable();
            $table->string('rank')->nullable();
            $table->string('tarif')->nullable();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->enum('role', ['admin', 'coach', 'student'])->default('student');
            $table->string('profile_picture')->nullable();
            $table->string('biographie')->nullable();
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
