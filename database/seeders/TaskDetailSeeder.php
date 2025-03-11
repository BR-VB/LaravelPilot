<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskDetail;
use App\Models\TaskDetailType;
use Illuminate\Database\Seeder;

class TaskDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $task = Task::create([
            'title' => 'Task with detail steps',
            'description' => 'First task with further detail steps to describe what happend.',
            'scope_id' => 42,
        ]);

        //note
        $taskDetailType = TaskDetailType::where('title', 'note')->first();

        $taskDetails = [
            ['created_at' => $now, 'updated_at' => $now, 'task_id' => $task->id, 'task_detail_type_id' => $taskDetailType->id, 'description' => 'I am a notice'],
        ];
        TaskDetail::insert($taskDetails);

        //command
        $taskDetailType = TaskDetailType::where('title', 'command')->first();
        $taskDetails = [
            ['created_at' => $now, 'updated_at' => $now, 'task_id' => $task->id, 'task_detail_type_id' => $taskDetailType->id, 'description' => 'php artisan migrate'],
        ];
        TaskDetail::insert($taskDetails);

        //code
        $taskDetailType = TaskDetailType::where('title', 'code')->first();
        $taskDetails = [
            ['created_at' => $now, 'updated_at' => $now, 'task_id' => $task->id, 'task_detail_type_id' => $taskDetailType->id, 'description' => '<pre>if ($a == $b) {
   $c = true;
}</pre>'],
        ];
        TaskDetail::insert($taskDetails);
    }
}
