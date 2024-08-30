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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('genre_id')->nullable()->constrained('genres')->onDelete('set null');
            $table->foreignId('matching_format_id')->nullable()->constrained('matching_formats')->onDelete('set null');
            $table->text('introduse')->nullable(); // 自己紹介
            $table->string('book_title')->nullable(); // 本のタイトル
            $table->string('author')->nullable(); // 著者
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['genre_id']);
            $table->dropColumn('genre_id');
            $table->dropForeign(['matching_format_id']);
            $table->dropColumn('matching_format_id');
            $table->dropColumn(['introduse', 'book_title', 'author']);
        });
    }
};
