<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Kyslik\ColumnSortable\Sortable;
use Ramsey\Uuid\Uuid;

class BuktiKas extends Model
{
    use HasFactory, HasUuids, Sortable;

    protected $table = 'bukti_kas';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'tanda_terima_id', 'nomer', 'tanggal', 'kas', 'jumlah', 'no_cek', 'status'
    ];

    public $sortable = [
        'tanggal', 'tanda_terima.tanggal_jatuh_tempo', 'created_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function tanda_terima(): BelongsTo {
        return $this->belongsTo(TandaTerima::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->whereHas('tanda_terima', fn($query) => 
                $query->whereHas('supplier', fn($query) => 
                    $query->where('name', 'like', '%' . $search . '%')
                )
            )
        )->when(
            isset($filters['jatuh_tempo']),
            function ($query) use ($filters) {
                $date = Carbon::createFromFormat('Y-m-d', $filters['jatuh_tempo']);
                $formattedDate = $date->format('d-m-Y');

                // Ensure that the relationship and table column are correctly referenced
                $query->whereHas('tanda_terima', function ($query) use ($formattedDate) {
                    $query->where('tanggal_jatuh_tempo', '=', $formattedDate);
                });
            }
        );
    }
}
