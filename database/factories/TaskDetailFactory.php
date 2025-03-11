<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskDetailType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskDetail>
 */
class TaskDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taskDetailType = TaskDetailType::first();
        $task = Task::first();

        return [
            'description' => fake()->text(50),
            'task_id' => $task->id,
            'task_detail_type_id' => $taskDetailType->id,
        ];
    }

    public function withTaskAndTaskDetailType(Task $task, TaskDetailType $taskDetailType): static
    {
        return $this->state([
            'task_id' => $task->id,
            'task_detail_type_id' => $taskDetailType->id,
        ]);
    }
}
