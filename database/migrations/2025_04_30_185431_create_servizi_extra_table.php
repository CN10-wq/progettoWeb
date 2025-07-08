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
        Schema::create('servizi_extra', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->text('descrizione')->nullable();
            $table->decimal('prezzo', 8, 2)->default(0);
            $table->string('prezzo_unita')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servizi_extra');
    }
};
