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
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'distributor_id')) {
                $table->dropForeign(['distributor_id']);
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            $legacyColumns = [
                'order_id',
                'supplier',
                'product',
                'quantity',
                'expected_delivery',
                'status',
                'total_price',
                'distributor_id',
            ];

            $existingColumns = array_values(array_filter($legacyColumns, fn (string $column) => Schema::hasColumn('orders', $column)));

            if (!empty($existingColumns)) {
                $table->dropColumn($existingColumns);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Legacy columns intentionally not restored.
    }
};
