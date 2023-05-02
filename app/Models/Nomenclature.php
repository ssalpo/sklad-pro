<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nomenclature extends Model
{
    use HasFactory, SoftDeletes, DatesFormatable;

    protected $fillable = [
        'company_id',
        'name',
        'base_price',
        'price_for_sale',
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }
}
