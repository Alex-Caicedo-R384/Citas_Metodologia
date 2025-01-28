<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            // Relación con el usuario que crea la cita
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade'); // Cascada permitida para user_id

            // Relación con el usuario con quien se agenda la cita
            $table->foreignId('partner_id')
                ->nullable()
                ->constrained('users'); // Sin onDelete, comportamiento por defecto

            $table->dateTime('date'); // Fecha y hora de la cita
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
