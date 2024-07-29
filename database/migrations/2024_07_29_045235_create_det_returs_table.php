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
        Schema::create('det_retur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retur_id')->constrained('retur');
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('qty');
            $table->integer('harga_jual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_retur');
    }
};
