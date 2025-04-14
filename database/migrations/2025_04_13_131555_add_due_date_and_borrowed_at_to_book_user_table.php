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
        Schema::table('book_user', function (Blueprint $table) {
            $table->date('due_date')->nullable();
            $table->date('borrowed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_user', function (Blueprint $table) {
            $table->dropColumn(['due_date', 'borrowed_at']);
        });
    }
};
