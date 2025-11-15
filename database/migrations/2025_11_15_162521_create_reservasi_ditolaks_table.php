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
        Schema::create('reservasi_ditolak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservasi')->onDelete('cascade')->onUpdate('cascade');
            $table->text('alasan_ditolak');
            $table->string('ditolak_oleh', 50);
            $table->timestamp('cancelled_at')->useCurrent();
            // Tabel ini tidak menggunakan timestamps()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi_ditolaks');
    }
};
