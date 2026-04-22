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
        if (!Schema::hasTable('businesses')) {
            Schema::create('businesses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
                $table->string('business_name');
                $table->string('address');
                $table->string('contact_person')->nullable();
            });
        }

        if (!Schema::hasTable('egg_products')) {
            Schema::create('egg_products', function (Blueprint $table) {
                $table->id();
                $table->enum('category', ['Small', 'Medium', 'Large', 'Tray']);
                $table->decimal('price_per_unit', 10, 2);
                $table->integer('stock_quantity');
                $table->integer('low_stock_threshold')->nullable();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->integer('order_id');
                $table->foreignId('product_id')->constrained('egg_products')->cascadeOnDelete();
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2);
            });
        }

        if (!Schema::hasTable('deliveries')) {
            Schema::create('deliveries', function (Blueprint $table) {
                $table->id();
                $table->integer('order_id')->unique();
                $table->foreignId('distributor_id')->nullable()->constrained('businesses')->nullOnDelete();
                $table->enum('delivery_status', ['Preparing', 'On the Way', 'Delivered'])->default('Preparing');
                $table->string('delivery_address');
                $table->integer('suggested_sequence')->nullable();
                $table->timestamp('actual_delivery_time')->nullable();
            });
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('orders', 'customer_type')) {
                $table->enum('customer_type', ['registered', 'guest'])->default('registered')->after('user_id');
            }

            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->nullable()->unique()->after('customer_type');
            }

            if (!Schema::hasColumn('orders', 'order_status')) {
                $table->enum('order_status', ['Pending', 'In Progress', 'Completed'])->default('Pending')->after('order_number');
            }

            if (!Schema::hasColumn('orders', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->after('order_status')->constrained('businesses')->nullOnDelete();
            }

            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0)->after('supplier_id');
            }

            if (!Schema::hasColumn('orders', 'updated_at')) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('deliveries')) {
            Schema::dropIfExists('deliveries');
        }

        if (Schema::hasTable('order_items')) {
            Schema::dropIfExists('order_items');
        }

        if (Schema::hasTable('egg_products')) {
            Schema::dropIfExists('egg_products');
        }

        if (Schema::hasTable('businesses')) {
            Schema::dropIfExists('businesses');
        }
    }
};
