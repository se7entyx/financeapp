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
        Schema::create('tanda_terima', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('increment_id')->unique();
            $table->uuid('user_id')->index();
            $table->string('tanggal');
            $table->uuid('supplier_id')->index();
            $table->string('pajak');
            $table->string('po');
            $table->string('bpb');
            $table->string('surat_jalan');
            $table->string('nomor_po')->nullable();            
            $table->string('tanggal_jatuh_tempo');
            $table->string('currency');
            $table->text('keterangan')->nullable();
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanda_terima');
    }
};
