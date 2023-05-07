<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes, DatesFormatable;

    protected $fillable = ['company_id', 'name'];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
