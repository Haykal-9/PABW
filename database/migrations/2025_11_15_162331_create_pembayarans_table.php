<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('order_date')->useCurrent();
            $table->foreignId('status_id')->constrained('payment_status')->onUpdate('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onUpdate('cascade');
            $table->foreignId('order_type_id')->constrained('order_types')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
