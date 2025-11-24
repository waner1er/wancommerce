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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('total');
            $table->foreignId('shipping_rate_id')->nullable()->constrained()->after('shipping_cost');
            $table->json('shipping_address')->nullable()->after('shipping_rate_id');
            $table->decimal('total_weight', 8, 3)->default(0)->after('shipping_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shipping_rate_id']);
            $table->dropColumn(['shipping_cost', 'shipping_rate_id', 'shipping_address', 'total_weight']);
        });
    }
};
