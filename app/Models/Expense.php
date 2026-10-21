<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = ['user_id', 'demo_visitor_id', 'type', 'category', 'title', 'amount', 'expense_date', 'notes'];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'expense_date' => 'date'];
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(DemoVisitor::class, 'demo_visitor_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
