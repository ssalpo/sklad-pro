<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class NomenclatureArrival extends Model
{
    use HasFactory, SoftDeletes, DatesFormatable;

    protected $fillable = [
        'company_id',
        'nomenclature_id',
        'quantity',
        'base_price',
        'price_for_sale',
        'comment',
        'arrival_at',
    ];

    protected $casts = [
        'arrival_at' => 'datetime',
        'quantity' => 'double'
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }

    public function scopeFilters($q, array $data): void
    {
        $q->when(
            Arr::get($data, 'query'),
            fn($q, $v) => $q->whereHas(
                'nomenclature',
                fn($q) => $q->where('name', 'like', '%' . $v . '%')
            )
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function nomenclature(): BelongsTo
    {
        return $this->belongsTo(Nomenclature::class)->withTrashed();
    }

    public function getArrivalAtFormattedAttribute()
    {
        return $this->arrival_at?->format('d-m-Y H:i');
    }
}
