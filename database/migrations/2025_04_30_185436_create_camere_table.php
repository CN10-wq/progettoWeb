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
        Schema::create('camere', function (Blueprint $table) {
            $table->id();
            $table->string('titolo');
            $table->foreignId('tipo_id')->constrained('tipi_camere')->onDelete('cascade');
            $table->decimal('prezzo_a_notte', 8, 2)->default(0);
            $table->text('descrizione')->nullable();
            $table->integer('capienza')->default(2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camere');
    }
};
