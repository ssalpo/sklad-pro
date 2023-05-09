<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Order extends Model
{
    use HasFactory, SoftDeletes, DatesFormatable;

    protected $fillable = [
        'showcase_id',
        'company_id',
        'user_id',
        'client_id',
        'amount',
        'profit',
        'status',
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    public const STATUS_SOLD = 1;
    public const STATUS_CANCELED = 2;

    public const STATUS_LABELS = [
        self::STATUS_SOLD => 'Продано',
        self::STATUS_CANCELED => 'Отменен',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
    }

    public function scopeFilter($q, $data): void
    {
        $q->when(
            Arr::get($data, 'client'),
            fn($q, $v) => $q->where('client_id', $v)
        );

        $q->when(
            Arr::get($data, 'user'),
            fn($q, $v) => $q->where('user_id', $v)
        );

        $q->when(
            Arr::get($data, 'id'),
            fn($q, $v) => $q->where('id', $v)
        );
    }

    public function showcase(): BelongsTo
    {
        return $this->belongsTo(Showcase::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
