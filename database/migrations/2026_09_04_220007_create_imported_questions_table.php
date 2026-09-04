<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imported_questions', function (Blueprint $table) {
            $table->id();
            $table->string('source')->default('quizapi.io');
            $table->string('external_id')->unique();
            $table->string('quiz_external_id')->nullable();
            $table->string('quiz_title')->nullable();
            $table->text('text');
            $table->string('type')->nullable();
            $table->string('difficulty')->nullable();
            $table->text('explanation')->nullable();
            $table->string('category')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imported_questions');
    }
};
