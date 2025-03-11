<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tableName = $this->faker->randomElement(['projects', 'scopes', 'tasks', 'task_details', 'task_detail_types']);
        $fieldName = $this->getFieldNameByTableName($tableName);

        return [
            'table_name' => $tableName,
            'field_name' => $fieldName,
            'record_id' => fake()->numberBetween(1, 100),
            'value' => fake()->word(),
        ];
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
        };
    }
}
