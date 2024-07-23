<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeteranganBuktiKas extends Model
{
    use HasFactory;
    protected $fillable = [
        'keterangan',
        'dk',
        'jumlah',
        'currency'
    ];

    public function bukti_kas(): BelongsTo{
        return $this->belongsTo(BuktiKas::class);
    }
}
