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
            $table->index(['title'], 'tasks_title_index');
            $table->index(['occurred_at', 'title'], 'tasks_occurred_at_title_index');
            $table->index(['updated_at', 'title'], 'tasks_updated_at_title_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_title_index');
            $table->dropIndex('tasks_occurred_at_title_index');
            $table->dropIndex('tasks_updated_at_title_index');
        });
    }
};
