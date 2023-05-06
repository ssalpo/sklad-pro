<?php

namespace App\Models;

use App\Models\Scopes\CurrentCompanyScope;
use App\Models\Traits\DatesFormatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'send_at',
    ];

    protected $casts = [
        'send_at' => 'datetime'
    ];

    protected $appends = [
        'created_at_formatted'
    ];

    public const STATUS_NEW = 1;
    public const STATUS_SEND = 2;
    public const STATUS_CANCELED = 3;

    public const STATUS_LABELS = [
        self::STATUS_NEW => 'Новый',
        self::STATUS_SEND => 'Отправлен',
        self::STATUS_CANCELED => 'Отменен',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new CurrentCompanyScope);
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
