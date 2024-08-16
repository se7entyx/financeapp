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
use Ramsey\Uuid\Uuid;

class BuktiKas extends Model
{
    use HasFactory, Notifiable,HasUuids;
    protected $table = 'bukti_kas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'user_id', 'tanda_terima_id', 'nomer', 'tanggal', 'kas', 'jumlah', 'no_cek', 'status'
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

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->whereHas('tanda_terima', fn($query) => $query->whereHas('supplier', fn($query) => $query->where('name', 'like', '%' . $search . '%')))
        )->when(
            isset($filters['jatuh_tempo']),
            fn($query) => $query->whereHas('tanda_terima', function ($query) use ($filters) {
                // Parse the date from the filters array
                $date = Carbon::createFromFormat('Y-m-d', $filters['jatuh_tempo']);
                // Format the date to d-m-Y
                $formattedDate = $date->format('d-m-Y');
                // Use the formatted date in the query
                $query->where('tanggal_jatuh_tempo', '=', $formattedDate);   
            })
        )->when(
            isset($filters['order']),
            fn ($query, $order) =>
            $query
        );
    }
}
