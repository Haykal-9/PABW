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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('url_foto')->nullable();
            $table->foreignId('type_id')->constrained('menu_types')->onUpdate('cascade');
            $table->decimal('price', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->foreignId('status_id')->constrained('menu_status')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
