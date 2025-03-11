<?php

namespace Database\Seeders;

use App\Models\ActivityType;
use Illuminate\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $activityTypes = [
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'create', 'label' => 'Create'],
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'delete', 'label' => 'Delete'],
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'update', 'label' => 'Update'],
            ['created_at' => $now, 'updated_at' => $now, 'title' => 'query', 'label' => 'Query'],
        ];

        ActivityType::insert($activityTypes);
    }
}
