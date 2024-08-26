<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'keterangan',
        'nominal',
        'nominal_setelah',
        'nominal_ppn',
        'nominal_pph',
        'id_ppn',
        'id_pph'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function invoices(): BelongsTo
    {
        return $this->belongsTo(Invoices::class);
    }

    public function tax(): HasMany
    {
        return $this->hasMany(Tax::class);
    }
}
