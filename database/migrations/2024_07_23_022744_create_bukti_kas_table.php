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
        Schema::create('bukti_kas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tanda_terima_id');
            $table->string('nomer');
            $table->string('tanggal')->nullable();
            $table->string('kas');
            $table->integer('jumlah');
            $table->string('no_cek');
            // $table->date('tanggal_jatuh_tempo');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tanda_terima_id')->references('id')->on('tanda_terima')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_kas');
    }
};
