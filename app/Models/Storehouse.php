<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\CurrentUser;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storehouse extends Model
{
    use HasFactory, CurrentUser, DatesFormatable, SoftDeletes;

    protected $fillable = [
        'name',
        'company_id',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }

    public function notDefault($q): void
    {
        $q->where('is_default', false);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function getDefault(string $onlyField = null)
    {
        if($onlyField) {
            return self::where('is_default', true)->select($onlyField)->firstOrFail()[$onlyField];
        }

        return self::where('is_default', true)->firstOrFail();
    }
}
