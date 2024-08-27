<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Invoices extends Model
{
    use HasFactory,HasUuids;
    protected $keyType = 'string'; // UUID is a string
    public $incrementing = false; // Disable auto-incrementing
    protected $fillable = [
        'tanda_terima_id',
        'nomor',
        'nominal',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid7()->toString();
        });
    }

    public function tandaTerima(): BelongsTo{
        return $this->belongsTo(TandaTerima::class,'tanda_terima_id');
    }

    public function transaction(): HasMany{
        return $this->hasMany(Transaction::class, 'invoice_id');
    }
}