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
        Schema::create('books', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->string('title')->nullable(false);
            $table->string('author')->nullable(false);
            $table->text('description')->nullable();
            $table->string('publisher')->nullable(false);
            $table->year('published_year')->nullable();
            $table->date('publication_date')->nullable();
            $table->integer('page_count')->default(0);
            $table->string('category')->nullable(false);
            $table->string('isbn')->nullable(false);
            $table->text('summary')->nullable();
            $table->string('cover_image')->nullable();
            $table->integer('stock')->default(0);
            $table->boolean('isCheckedOut')->default(false);
            $table->boolean('available')->default(true);
            $table->boolean('isFeatured')->default(false);
            $table->integer('rating')->default(0); // Default rating to 0


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
