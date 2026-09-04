<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('imported_questions', function (Blueprint $table) {
            $table->foreignId('imported_category_id')
                ->nullable()
                ->after('category')
                ->constrained('imported_categories')
                ->nullOnDelete();
        });

        // Backfill: turn each distinct raw `category` string into a row in
        // imported_categories, and link existing questions to it.
        $categories = DB::table('imported_questions')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        foreach ($categories as $name) {
            $categoryId = DB::table('imported_categories')->insertGetId([
                'source' => 'quizapi.io',
                'name' => $name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('imported_questions')
                ->where('category', $name)
                ->update(['imported_category_id' => $categoryId]);
        }

        Schema::table('imported_questions', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('imported_questions', function (Blueprint $table) {
            $table->string('category')->nullable()->after('quiz_title');
        });

        DB::table('imported_questions')
            ->join('imported_categories', 'imported_questions.imported_category_id', '=', 'imported_categories.id')
            ->update(['imported_questions.category' => DB::raw('imported_categories.name')]);

        Schema::table('imported_questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('imported_category_id');
        });
    }
};
