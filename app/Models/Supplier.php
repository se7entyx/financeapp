<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function tanda_terima(): HasMany{
        return $this->hasMany(TandaTerima::class,'supplier_id');
    }
}
