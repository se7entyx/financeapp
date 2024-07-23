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
        Schema::create('form_bank', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bukti_kas_id');
            $table->timestamps();

            $table->foreign('bukti_kas_id')->references('id')->on('bukti_kas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_bank');
    }
};
