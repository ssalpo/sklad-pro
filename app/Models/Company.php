<?php

namespace App\Models;

use App\Models\Traits\CurrentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, CurrentUser;

    protected $fillable = [
        'user_id',
        'name',
        'email_show',
        'email_required',
        'phone_show',
        'phone_required',
        'phone_required_review_gte_than',
        'logo'
    ];

    protected $casts = [
        'email_show' => 'boolean',
        'email_required' => 'boolean',
        'phone_show' => 'boolean',
        'phone_required' => 'boolean'
    ];

    protected $appends = [
        'logo_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLogoUrlAttribute()
    {
        return '/storage/' . $this->logo;
    }
}
