<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('suppliers');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Legacy tables intentionally not restored.
    }
};
