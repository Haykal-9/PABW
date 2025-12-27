<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan status 'processing' ke tabel payment_status
        DB::table('payment_status')->insert([
            'id' => 4,
            'status_name' => 'processing',
            'description' => 'Pesanan sedang diproses'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('payment_status')->where('id', 4)->delete();
    }
};
