<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::factory()->create([
            'is_featured' => true,
        ]);

        Project::factory()->create([
            'is_featured' => false,
        ]);
    }
}
