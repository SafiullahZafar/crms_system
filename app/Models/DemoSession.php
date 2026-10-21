<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DemoSession extends Model
{
    protected $fillable = ['demo_visitor_id', 'token_hash', 'visitor_hash', 'browser', 'platform', 'started_at', 'last_seen_at', 'ended_at'];

    protected function casts(): array
    {
        return ['started_at' => 'datetime', 'last_seen_at' => 'datetime', 'ended_at' => 'datetime'];
    }

    public function activities(): HasMany
    {
        return $this->hasMany(DemoActivity::class);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(DemoVisitor::class, 'demo_visitor_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('ended_at')->where('last_seen_at', '>=', now()->subMinutes((int) config('demo.session_timeout_minutes', 30)));
    }
}
