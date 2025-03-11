<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Scope;
use Illuminate\Database\Seeder;

class ScopeSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $project = Project::first();

        $scopes = [
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'install', 'label' => 'Install', 'is_featured' => true, 'column' => 1, 'sortorder' => 5],
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'configure', 'label' => 'Configure', 'is_featured' => true, 'column' => 1, 'sortorder' => 10],
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'organize', 'label' => 'Organize', 'is_featured' => true, 'column' => 1, 'sortorder' => 15],
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'others', 'label' => 'Others', 'is_featured' => true, 'column' => 1, 'sortorder' => 20],
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'todo', 'label' => 'ToDo', 'is_featured' => true, 'column' => 2, 'sortorder' => 5],
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'maybe', 'label' => 'MayBe', 'is_featured' => true, 'column' => 2, 'sortorder' => 10],
            ['created_at' => $now, 'updated_at' => $now, 'project_id' => $project->id, 'title' => 'develop', 'label' => 'Last Activities', 'is_featured' => true, 'column' => 2, 'sortorder' => 15],
        ];

        Scope::insert($scopes);
    }
}
