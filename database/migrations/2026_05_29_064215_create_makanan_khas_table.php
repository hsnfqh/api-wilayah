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
        Schema::create('makanan_khas', function (Blueprint $table) {
            $table->id();
            $table->string('province_id', 10)->index();
            $table->string('province_name');
            $table->string('nama_makanan');
            $table->text('deskripsi')->nullable();
            $table->string('foto_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makanan_khas');
    }
};
