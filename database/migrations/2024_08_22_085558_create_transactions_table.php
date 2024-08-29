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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('invoice_id');
            $table->text('keterangan');
            $table->double('nominal');
            $table->double('nominal_ppn')->nullable();
            $table->double('nominal_pph')->nullable();
            $table->uuid('id_ppn')->nullable();
            $table->uuid('id_pph')->nullable();
            $table->timestamps();

            $table->foreign('id_ppn')->references('id')->on('taxes')->onDelete('cascade');
            $table->foreign('id_pph')->references('id')->on('taxes')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
