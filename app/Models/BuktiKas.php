<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BuktiKas extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomer',
        'tanggal',
        'kas',
        'jumlah',
        'no_cek',
        // 'tanggal_jatuh_tempo',
        'total_jumlah'
    ];

    public function keterangan_bukti_kas():HasMany {
        return $this->hasMany(KeteranganBuktiKas::class,foreignKey:'bukti_kas_id');
    }

    public function tanda_terima():HasOne {
        return $this->hasOne(TandaTerima::class, foreignKey:'tanda_terima_id');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function form_bank(): BelongsTo{
        return $this->belongsTo(FormBank::class);
    }
}
