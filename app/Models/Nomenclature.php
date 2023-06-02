<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Nomenclature extends Model
{
    use HasFactory, SoftDeletes, DatesFormatable;

    protected $fillable = [
        'company_id',
        'name',
        'base_price',
        'price_for_sale',
        'unit_id',
        'barcode'
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }

    public function scopeFilters($q, $data): void
    {
        $q->when(
            Arr::get($data, 'query'),
            fn($q, $v) => $q->where('name', 'like', "%$v%")
                ->orWhere('barcode', 'like', "%$v%")
                ->orWhere('base_price', $v)
                ->orWhere('price_for_sale', $v)
        );
    }

    public function nomenclatureArrivals(): HasMany
    {
        return $this->hasMany(NomenclatureArrival::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class)->withTrashed();
    }
}
