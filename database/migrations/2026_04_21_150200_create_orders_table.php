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
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->enum('customer_type', ['registered', 'guest'])->default('registered');
                $table->string('order_number')->nullable()->unique();
                $table->enum('order_status', ['Pending', 'In Progress', 'Completed'])->default('Pending');
                $table->unsignedBigInteger('supplier_id')->nullable();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
