<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DemoVisitor extends Model
{
    protected $fillable = ['token_hash'];

    public function sessions(): HasMany
    {
        return $this->hasMany(DemoSession::class);
    }

    public function activities(): HasManyThrough
    {
        return $this->hasManyThrough(DemoActivity::class, DemoSession::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(DemoRecord::class);
    }
}
