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
            $table->string('status')->nullable();
            $table->date('deliveryDate')->nullable(); //fecha de entrega
            $table->date('applicationDate')->nullable(); //fecha de solicitud
            $table->unsignedBigInteger('userId')->default(2);
            $table->unsignedBigInteger('supplierId')->nullable();
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
