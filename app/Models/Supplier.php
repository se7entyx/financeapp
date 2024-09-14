<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Supplier extends Model
{
    use HasFactory, HasUuids;
    protected $keyType = 'string'; // UUID is a string
    public $incrementing = false; // Disable auto-incrementing
    protected $fillable = ['name', 'no_rek', 'bank','status'];
    public function tanda_terima(): HasMany
    {
        return $this->hasMany(TandaTerima::class, 'supplier_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function scopeSearch(Builder $query): void 
    {
        $query->where('name', 'like', '%' . request('search') . '%');
    }
}
