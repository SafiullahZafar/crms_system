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
        Schema::table('demo_visitors', function (Blueprint $table): void {
            $table->timestamp('workspace_seeded_at')->nullable();
        });

        Schema::create('demo_records', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('demo_visitor_id')->constrained()->cascadeOnDelete();
            $table->string('module', 40);
            $table->string('title', 160);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['demo_visitor_id', 'module']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_records');

        Schema::table('demo_visitors', function (Blueprint $table): void {
            $table->dropColumn('workspace_seeded_at');
        });
    }
};
