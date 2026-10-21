<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoActivity extends Model
{
    public $timestamps = false;

    protected $fillable = ['demo_session_id', 'event', 'page', 'action', 'created_at'];

    protected function casts(): array
    {
        return ['created_at' => 'datetime'];
    }

    public function demoSession(): BelongsTo
    {
        return $this->belongsTo(DemoSession::class);
    }
}
