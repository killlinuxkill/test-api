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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->unsignedBigInteger('language_id');
            //$table->timestamp('created_at');
            //$table->timestamp('updated_at');
            //$table->timestamp('deleted_at')->nullable(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('language_id')->references('id')->on('languages');
            $table->unique(['name', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
