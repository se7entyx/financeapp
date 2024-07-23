<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TandaTerima extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'pajak',
        'po',
        'bpb',
        'surat_jalan',
        'tanggal_jatuh_tempo',
        'keterangan'
    ];

    public function invoice(): HasMany{
        return $this->hasMany(Invoices::class,foreignKey:'tanda_terima_id');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function bukti_kas(): BelongsTo{
        return $this->belongsTo(BuktiKas::class);
    }


}
