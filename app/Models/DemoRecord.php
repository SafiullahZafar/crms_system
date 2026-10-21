<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoRecord extends Model
{
    protected $fillable = ['demo_visitor_id', 'module', 'title', 'description'];

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(DemoVisitor::class, 'demo_visitor_id');
    }
}
