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
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->foreignId('scope_id')->constrained()->onDelete('restrict');
            $table->char('locale', 2)->default('en');
            $table->boolean('is_featured')->default(false);
            $table->string('icon')->nullable();
            $table->string('prefix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->dropForeign(['scope_id']);
            $table->dropColumn('scope_id');
            $table->dropColumn('locale');
            $table->dropColumn('is_featured');
            $table->dropColumn('icon');
            $table->dropColumn('prefix');
        });
    }
};
