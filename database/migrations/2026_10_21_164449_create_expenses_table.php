<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('demo_visitors', 'expenses_seeded_at')) {
            Schema::table('demo_visitors', function (Blueprint $table): void {
                $table->timestamp('expenses_seeded_at')->nullable();
            });
        }

        Schema::create('expenses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('demo_visitor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('type', 20);
            $table->string('category', 80);
            $table->string('title', 160);
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'expense_date']);
            $table->index(['demo_visitor_id', 'expense_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');

        if (Schema::hasColumn('demo_visitors', 'expenses_seeded_at')) {
            Schema::table('demo_visitors', function (Blueprint $table): void {
                $table->dropColumn('expenses_seeded_at');
            });
        }
    }
};
