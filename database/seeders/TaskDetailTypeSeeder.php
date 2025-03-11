<?php

namespace Database\Seeders;

use App\Models\TaskDetailType;
use Illuminate\Database\Seeder;

class TaskDetailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $taskDetailTypes = [
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'note', 'label' => 'Note'],
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'command', 'label' => 'Command'],
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'code', 'label' => 'Code'],
        ];

        TaskDetailType::insert($taskDetailTypes);
    }
}
