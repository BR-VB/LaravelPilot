<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $translations = [
            ['table_name' => 'projects', 'field_name' => 'title', 'record_id' => '1', 'value' => 'ProjectNavigator (de)', 'locale' => 'de', 'created_at' => $now, 'updated_at' => $now],
            ['table_name' => 'projects', 'field_name' => 'title', 'record_id' => '2', 'value' => 'Neues Project', 'locale' => 'de', 'created_at' => $now, 'updated_at' => $now],
        ];

        Translation::insert($translations);
    }
}
