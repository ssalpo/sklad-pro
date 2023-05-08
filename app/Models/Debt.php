<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model
{
    use HasFactory, SoftDeletes, DatesFormatable;

    protected $fillable = [
        'company_id',
        'client_id',
        'created_by',
        'order_id',
        'amount',
        'comment',
        'is_paid'
    ];

    protected $casts = [
        'amount' => 'double',
        'is_paid' => 'bool',
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
