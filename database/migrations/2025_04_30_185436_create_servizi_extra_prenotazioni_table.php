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
        Schema::create('servizi_extra_prenotazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prenotazione_id')->constrained('prenotazioni')->onDelete('cascade');
            $table->foreignId('servizio_extra_id')->constrained('servizi_extra')->onDelete('cascade');
            $table->integer('quantita')->default(1);
            $table->decimal('prezzo_unitario', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servizi_extra_prenotazioni');
    }
};
