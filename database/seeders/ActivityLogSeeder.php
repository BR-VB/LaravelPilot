<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\ActivityType;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $user = User::where('id', '1')->first();

        //create
        $activityType = ActivityType::where('title', 'create')->first();
        $activityLogs = [
            ['user_id' => $user->id, 'activity_type_id' => $activityType->id, 'module' => 'auth', 'table_name' => 'users', 'field_name' => 'name', 'value' => 'Roberto Mancini', 'description' => 'I am a technical note.', 'created_at' => $now, 'updated_at' => $now],
        ];
        ActivityLog::insert($activityLogs);

        //delete
        $activityType = ActivityType::where('title', 'delete')->first();
        $activityLogs = [
            ['user_id' => $user->id, 'activity_type_id' => $activityType->id, 'module' => 'project', 'table_name' => 'projects', 'field_name' => 'title', 'value' => 'FirstTry', 'description' => 'I am a technical note.', 'created_at' => $now, 'updated_at' => $now],
        ];
        ActivityLog::insert($activityLogs);

        //update
        $activityType = ActivityType::where('title', 'update')->first();
        $activityLogs = [
            ['user_id' => $user->id, 'activity_type_id' => $activityType->id, 'module' => 'task', 'table_name' => 'task_details', 'field_name' => 'description', 'value' => 'New description', 'description' => null, 'created_at' => $now, 'updated_at' => $now],
        ];
        ActivityLog::insert($activityLogs);

        //query
        $activityType = ActivityType::where('title', 'query')->first();
        $activityLogs = [
            ['user_id' => $user->id, 'activity_type_id' => $activityType->id, 'module' => 'translation', 'table_name' => 'scopes', 'field_name' => '-', 'value' => 'results(15)/time(135ms)', 'description' => 'This is the query command.', 'created_at' => $now, 'updated_at' => $now],
        ];
        ActivityLog::insert($activityLogs);
    }
}
