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
        Schema::create('keterangan_bukti_kas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bukti_kas_id');
            $table->text('keterangan');
            $table->text('dk');
            $table->integer('jumlah');
            $table->timestamps();
    
            $table->foreign('bukti_kas_id')->references('id')->on('bukti_kas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterangan_bukti_kas');
    }
};
