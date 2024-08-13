<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Ramsey\Uuid\Uuid;

class TandaTerima extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tanda_terima';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'increment_id',
        'user_id',
        'tanggal',
        'supplier_id',
        'pajak',
        'po',
        'bpb',
        'surat_jalan',
        'tanggal_jatuh_tempo',
        'currency',
        'keterangan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
            $model->increment_id = static::max('increment_id') + 1;
        });
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoices::class, 'tanda_terima_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function bukti_kas(): HasOne
    {
        return $this->hasOne(BuktiKas::class, 'tanda_terima_id');
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->whereHas('supplier', fn($query) => $query->where('name', 'like', '%' . $search . '%'))
        )->when(
            isset($filters['start_date']) && isset($filters['end_date']),
            fn ($query) => $query->whereBetween('created_at', [
                $filters['start_date'],
                $filters['end_date']
            ])
        ); 
    }
}
