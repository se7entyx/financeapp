<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoices extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomor',
        'nomonial',
        'currency'
    ];

    public function tanda_terima(): BelongsTo{
        return $this->belongsTo(TandaTerima::class);
    }
}
