<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class BuktiKas extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'bukti_kas';
    protected $fillable = [
        // 'user_id',
        'tanda_terima_id',
        'nomer',
        'tanggal',
        'kas',
        'jumlah',
        'no_cek',
        // 'tanggal_jatuh_tempo',
    ];

    public function keterangan_bukti_kas():HasMany {
        return $this->hasMany(KeteranganBuktiKas::class,foreignKey:'bukti_kas_id');
    }

    public function tanda_terima(): BelongsTo {
        return $this->belongsTo(TandaTerima::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function form_bank(): BelongsTo{
        return $this->belongsTo(FormBank::class);
    }
}
