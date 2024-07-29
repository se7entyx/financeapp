<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeteranganBuktiKas extends Model
{
    use HasFactory;
    protected $fillable = [
        'bukti_kas_id',
        'keterangan',
        'dk',
        'jumlah',
    ];

    public function bukti_kas(): BelongsTo{
        return $this->belongsTo(BuktiKas::class);
    }
}
