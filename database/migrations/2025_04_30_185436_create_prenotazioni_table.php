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
        Schema::create('prenotazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('camera_id')->constrained('camere')->onDelete('cascade');
            $table->foreignId('stato_id')->default(3)->constrained('stati')->onDelete('cascade');
            $table->date('data_inizio');
            $table->date('data_fine');
            $table->time('ora_check_in')->default('15:00:00');
            $table->time('ora_check_out')->default('11:00:00');
            $table->text('eventuali_richieste_cliente')->nullable();
            $table->decimal('prezzo_totale_camera', 8, 2)->default(0);
            $table->integer(column: 'numero_persone')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prenotazioni');
    }
};
