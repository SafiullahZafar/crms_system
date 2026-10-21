<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demo_visitors', function (Blueprint $table): void {
            $table->id();
            $table->string('token_hash', 64)->unique();
            $table->timestamps();
        });

        Schema::table('demo_sessions', function (Blueprint $table): void {
            $table->foreignId('demo_visitor_id')->nullable()->constrained()->nullOnDelete();
        });

        $visitors = DB::table('demo_sessions')
            ->select('visitor_hash', DB::raw('MIN(id) as first_session_id'))
            ->whereNotNull('visitor_hash')
            ->groupBy('visitor_hash')
            ->orderBy('first_session_id')
            ->get();

        foreach ($visitors as $visitor) {
            $visitorId = DB::table('demo_visitors')->insertGetId([
                'token_hash' => $visitor->visitor_hash,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('demo_sessions')
                ->where('visitor_hash', $visitor->visitor_hash)
                ->update(['demo_visitor_id' => $visitorId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demo_sessions', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('demo_visitor_id');
        });

        Schema::dropIfExists('demo_visitors');
    }
};
