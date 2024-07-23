<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FormBank extends Model
{
    use HasFactory;
    public function bukti_kas():HasOne {
        return $this->hasOne(BuktiKas::class, foreignKey:'bukti_kas_id');
    }
}
