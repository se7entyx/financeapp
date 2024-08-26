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
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Kyslik\ColumnSortable\Sortable;

use function Laravel\Prompts\select;

class TandaTerima extends Model
{
    use HasFactory, HasUuids, Sortable;
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

    public $sortable = [
        'tanggal',
        'created_at',
        'tanggal_jatuh_tempo',
    ];

    public function tanggalSortable($query, $direction)
    {
        return $query->orderBy(DB::raw("STR_TO_DATE(tanggal, '%d-%m-%Y')"), $direction);
    }

    public function tanggalJatuhTempoSortable($query, $direction)
    {
        return $query->orderBy(DB::raw("STR_TO_DATE(tanggal_jatuh_tempo, '%d-%m-%Y')"), $direction);
    }

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
        return $this->hasMany(Invoices::class);
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
            fn($query, $search) =>
            $query->whereHas('supplier', fn($query) => $query->where('name', 'like', '%' . $search . '%'))
        )->when(
            isset($filters['start_date']) && isset($filters['end_date']),
            function ($query) use ($filters) {
                // Convert start_date and end_date to d-m-Y format
                $start = Carbon::createFromFormat('Y-m-d', $filters['start_date'])->format('d-m-Y');
                $end = Carbon::createFromFormat('Y-m-d', $filters['end_date'])->format('d-m-Y');

                // Apply the filtering conditions directly to the main query using date comparison
                $query->whereBetween(
                    DB::raw("STR_TO_DATE(tanggal, '%d-%m-%Y')"),
                    [DB::raw("STR_TO_DATE('$start', '%d-%m-%Y')"), DB::raw("STR_TO_DATE('$end', '%d-%m-%Y')")]
                );
            }
        )->when(
            isset($filters['jatuh_tempo']),
            function ($query) use ($filters) {
                $date = Carbon::createFromFormat('Y-m-d', $filters['jatuh_tempo'])->format('d-m-Y');
                $query->where('tanggal_jatuh_tempo', '=', $date);
            }
        );
    }
}
