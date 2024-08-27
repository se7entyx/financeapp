<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kyslik\ColumnSortable\Sortable;
use Ramsey\Uuid\Uuid;

class Tax extends Model
{
    use HasFactory, HasUuids,Sortable;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'percentage',
        'type',
        'status'
    ];

    public $sortable = [
        'name',
        'type',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
