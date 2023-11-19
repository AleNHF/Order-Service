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
            $table->decimal('total')->nullable();
            $table->unsignedInteger('qtyOrdered')->nullable();
            $table->string('status');
            $table->date('deliveryDate')->nullable();
            $table->date('applicationDate')->nullable();
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('supplierId');
            $table->timestamps();

            $table->foreign('supplierId')->references('id')->on('suppliers');
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
