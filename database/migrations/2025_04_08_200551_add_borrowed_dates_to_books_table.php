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
        Schema::table('books', function (Blueprint $table) {
            Schema::table('books', function (Blueprint $table) {
                // Add columns for borrowed date and due date
                $table->timestamp('borrowed_at')->nullable()->after('isFeatured');
                $table->timestamp('due_date')->nullable()->after('borrowed_at');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['borrowed_at', 'due_date']);
        });
    }
};
