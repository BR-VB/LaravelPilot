<?php

namespace Database\Seeders;

use App\Models\Scope;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        //install
        $scope = Scope::where('title', 'install')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'All installations done', 'is_featured' => true, 'icon' => '&#10004;'],
        ];
        Task::insert($tasks);

        //configure
        $scope = Scope::where('title', 'configure')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'Config XDebug for VSCode & Laravel', 'is_featured' => true, 'icon' => '&#8987;'],
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'Config Apache to serve ProjectNavigator', 'is_featured' => true, 'icon' => '&#8987;'],
        ];
        Task::insert($tasks);

        //organize
        $scope = Scope::where('title', 'organize')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'Meeting: code-review, feedback & planning next week', 'is_featured' => true, 'icon' => '&#8987;'],
        ];
        Task::insert($tasks);

        //others
        $scope = Scope::where('title', 'others')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'View this <a href="https://www.youtube.com/watch?v=wVCEpbLIyLU&list=PL8p2I9GklV46KYQnt-xJB9dhyG-e-zHnI&index=3">Laravel Video-Playlist</a>', 'is_featured' => true, 'icon' => '&#8987;'],
        ];
        Task::insert($tasks);

        //todo
        $scope = Scope::where('title', 'todo')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'Finish DB - Model (tables/migrations/models/factories/seeders)', 'is_featured' => true, 'icon' => '&#8987;'],
        ];
        Task::insert($tasks);

        //maybe
        $scope = Scope::where('title', 'maybe')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'implement a soft delete (trash)', 'is_featured' => true, 'icon' => '🤔'],
        ];
        Task::insert($tasks);

        //develop
        $scope = Scope::where('title', 'develop')->first();
        $tasks = [
            ['created_at' => $now, 'updated_at' => $now, 'scope_id' => $scope->id, 'title' => 'Layout: Safari - Korrektur Header', 'prefix' => '[10.12.]', 'is_featured' => true, 'icon' => '&#10004;'],
        ];
        Task::insert($tasks);
    }
}
