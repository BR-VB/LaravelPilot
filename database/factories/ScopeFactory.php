<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Scope>
 */
class ScopeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::select('id')->first();

        return [
            'title' => fake()->unique()->word(),
            'label' => fake()->word(),
            'project_id' => $project->id,
        ];
    }

    public function withProject(Project $project): static
    {
        return $this->state([
            'project_id' => $project->id,
        ]);
    }
}
