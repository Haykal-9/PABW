<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('target_pendapatan', function (Blueprint $table) {
            $table->id();
            $table->decimal('target', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('target_pendapatan');
    }
};
