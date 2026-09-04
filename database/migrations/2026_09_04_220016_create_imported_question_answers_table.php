<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imported_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imported_question_id')->constrained('imported_questions')->onDelete('cascade');
            $table->string('external_id')->nullable();
            $table->string('text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imported_question_answers');
    }
};
