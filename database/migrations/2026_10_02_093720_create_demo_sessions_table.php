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
        Schema::create('demo_sessions', function (Blueprint $table): void {
            $table->id();
            $table->string('token_hash', 64)->unique();
            $table->string('visitor_hash', 64)->index();
            $table->string('browser', 40)->nullable();
            $table->string('platform', 40)->nullable();
            $table->timestamp('started_at');
            $table->timestamp('last_seen_at')->index();
            $table->timestamp('ended_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_sessions');
    }
};
