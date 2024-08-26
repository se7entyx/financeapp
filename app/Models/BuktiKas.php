<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Kyslik\ColumnSortable\sortable;

class BuktiKas extends Model
{
    use HasFactory, Notifiable, HasUuids, Sortable;
    protected $table = 'bukti_kas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'tanda_terima_id',
        'nomer',
        'tanggal',
        'kas',
        'jumlah',
        'no_cek',
        'status',
        'keterangan'
    ];

    protected $sortable = [
        'tanggal',
        'tanda_terima.tanggal_jatuh_tempo',
        'created_at',
        'status'
    ];

    public function tanggalSortable($query, $direction)
    {
        return $query->orderBy(DB::raw("STR_TO_DATE(tanggal, '%d-%m-%Y')"), $direction);
    }

    public function tanggalJatuhTempoSortable($query, $direction)
    {
        return $query
            ->join('tanda_terima', 'bukti_kas.tanda_terima_id', '=', 'tanda_terima.id')
            ->where('bukti_kas.user_id', Auth::id())
            ->orderBy(DB::raw("STR_TO_DATE(tanda_terima.tanggal_jatuh_tempo, '%d-%m-%Y')"), $direction)
            ->select('bukti_kas.*'); // Ensure only bukti_kas columns are selected to avoid conflicts
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function tanda_terima(): BelongsTo
    {
        return $this->belongsTo(TandaTerima::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn($query, $search) =>
            $query->whereHas(
                'tanda_terima',
                fn($query) =>
                $query->whereHas(
                    'supplier',
                    fn($query) =>
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
