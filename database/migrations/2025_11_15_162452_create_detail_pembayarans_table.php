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
        Schema::create('detail_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('menu_id')->constrained('menu')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('quantity');
            $table->decimal('price_per_item', 10, 2);
            $table->text('item_notes')->nullable();
            // Tabel ini tidak menggunakan timestamps()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembayarans');
    }
};
