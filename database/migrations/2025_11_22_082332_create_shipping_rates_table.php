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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Ex: Colissimo, Chronopost
            $table->string('carrier'); // Ex: La Poste, Chronopost
            $table->decimal('weight_min', 8, 3); // Poids minimum en kg
            $table->decimal('weight_max', 8, 3); // Poids maximum en kg
            $table->decimal('price', 10, 2); // Prix HT
            $table->string('zone')->default('France'); // Zone géographique
            $table->integer('delivery_days_min')->nullable(); // Délai minimum
            $table->integer('delivery_days_max')->nullable(); // Délai maximum
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
