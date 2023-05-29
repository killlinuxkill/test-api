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
        Schema::create('post_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('language_id');
            $table->string('title', 255);
            $table->string('description', 500);
            $table->text('content');

            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('language_id')->references('id')->on('languages');

            $table->unique(['post_id', 'language_id']);

            // Also, we can add a fulltext index or use third-party systems for search
            $table->fullText('title');
            $table->fullText('description');
            $table->fullText('content');

            $table->fullText(['title', 'description', 'content']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_translations');
    }
};
