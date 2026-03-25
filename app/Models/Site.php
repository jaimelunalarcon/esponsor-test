<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Site extends Model
{
    protected $fillable = [
        'user_id',
        'public_name',
        'slug',
        'bio',
        'avatar_url',
        'banner_url',
        'draft_payload',
        'published_payload',
    ];

    protected $casts = [
        'draft_payload' => 'array',
        'published_payload' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;
}