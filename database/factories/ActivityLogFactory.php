<?php

namespace Database\Factories;

use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Dynamische Generierung basierend auf Abhängigkeiten
        $module = $this->faker->randomElement(['home', 'project', 'scope', 'task', 'tasktype', 'translation']);
        $tableName = $this->getTableNameByModule($module);
        $fieldName = $this->getFieldNameByTableName($tableName);

        return [
            'user_id' => User::factory(),
            'activity_type_id' => ActivityType::factory(),
            'module' => $module,
            'table_name' => $tableName,
            'field_name' => $fieldName,
            'value' => fake()->word(),
            'description' => fake()->text(65),
            'locale' => $this->faker->randomElement(['en', 'de']),
        ];
    }

    /**
     * Define a state with specific user and activity type.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withUserAndActivity(User $user, ActivityType $activityType): self
    {
        return $this->state(fn () => [
            'user_id' => $user->id,
            'activity_type_id' => $activityType->id,
        ]);
    }

    /**
     * Get table name based on the module.
     */
    private function getTableNameByModule(string $module): string
    {
        return match ($module) {
            'home' => 'projects',
            'project' => 'projects',
            'scope' => 'scopes',
            'task' => 'tasks',
            'tasktype' => $this->faker->randomElement(['task_details', 'task_detail_types']),
            'translation' => 'translations',
            default => 'projects',
        };
    }

    /**
     * Get field name based on the table name.
     */
    private function getFieldNameByTableName(string $tableName): string
    {
        return match ($tableName) {
            'projects' => $this->faker->randomElement(['title', 'description']),
            'scopes' => $this->faker->randomElement(['title', 'label']),
            'tasks' => $this->faker->randomElement(['title', 'description']),
            'task_detail_types' => $this->faker->randomElement(['title', 'label']),
            'task_details' => 'description',
            'translations' => $this->faker->randomElement(['table_name', 'field_name'.'record_id', 'value']),
            default => 'title',
        };
    }
}
