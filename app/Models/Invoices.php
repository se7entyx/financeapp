<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoices extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanda_terima_id',
        'nomor',
        'nominal',
        'currency'
    ];

    public function tandaTerima(): BelongsTo{
        return $this->belongsTo(TandaTerima::class);
    }
}
