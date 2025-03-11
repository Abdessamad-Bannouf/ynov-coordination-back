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
        // Table des quizz
        Schema::create('quizzs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('description')->nullable();
            $table->string('category');
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard']);
            $table->string('correct_answer')->nullable();
            $table->text('explanation')->nullable();
            $table->boolean('multiple_correct_answers');
            $table->timestamps();
        });

        // Table des réponses possibles
        Schema::create('quizz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizz_id')->constrained('quizzs')->onDelete('cascade');
            $table->string('answer_key');
            $table->string('answer_text');
            $table->timestamps();
        });

        // Table des réponses correctes
        Schema::create('quizz_correct_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizz_id')->constrained('quizzs')->onDelete('cascade');
            $table->string('answer_key');
            $table->boolean('is_correct');
            $table->timestamps();
        });

        // Table des tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        // Table pivot pour associer les quizz et les tags
        Schema::create('quizz_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quizz_id')->constrained('quizzs')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizz_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('quizz_correct_answers');
        Schema::dropIfExists('quizz_answers');
        Schema::dropIfExists('quizzs');
    }
};
