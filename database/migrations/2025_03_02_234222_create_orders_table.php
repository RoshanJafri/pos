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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->integer('table_no');
            $table->string('payment_method')->nullable();
            $table->integer('subtotal');
            $table->integer('tax');
            $table->integer('discountPercentage');
            $table->integer('payable');
            $table->string('note')->nullable();
            $table->string('order_type');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
