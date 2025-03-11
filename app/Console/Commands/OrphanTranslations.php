<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\OrphanTranslationsNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

class OrphanTranslations extends Command
{
    //protected $signature = 'app:orphan-translations {--paramName=1}';
    protected $signature = 'app:orphan-translations';

    protected $description = 'OrphanTranslations';

    public function __construct()
    {
        parent::__construct();
        $this->description = __('commands.orphan_translations_description');
    }

    //Execute the console command
    public function handle()
    {
        //$paramValue = $this->option('paramName');
        $tables = DB::table('translations')->select('table_name')->distinct()->pluck('table_name');
        $missingRecords = $this->getMissingRecords($tables);
        $missingFields = $this->getMissingTableFields($tables);

        //use notification
        if (! empty($missingRecords) || ! empty($missingTableFields)) {
            $users = User::where('is_admin', true)->get();
            $details['missingRecords'] = $missingRecords ?? [];
            $details['missingFields'] = $missingFields ?? [];

            Notification::send($users, new OrphanTranslationsNotification($details));
        }
    }

    //
    //Private Functions
    //

    private function getMissingRecords($tables): array
    {
        $missingRecords = [];

        foreach ($tables as $tableName) {
            $missingTableRecords = DB::table('translations')
                ->where('table_name', $tableName)
                ->whereNotExists(function ($query) use ($tableName) {
                    $query->select(DB::raw(1))
                        ->from($tableName)
                        ->whereColumn("$tableName.id", 'translations.record_id');
                })
                ->select('record_id')->get()->pluck('record_id');

            if ($missingTableRecords->isNotEmpty()) {
                $missingRecords[$tableName] = $missingTableRecords->toArray();
            }
        }

        return $missingRecords;
    }

    private function getMissingTableFields($tables): array
    {
        $missingTableFields = [];

        foreach ($tables as $tableName) {
            if (! Schema::hasTable($tableName)) {
                $missingTableFields[$tableName]['tableMissing'] = true;

                continue;
            }

            $translations = DB::table('translations')
                ->where('table_name', $tableName)
                ->select('table_name', 'field_name')->distinct()
                ->get();

            foreach ($translations as $translation) {
                $fieldName = $translation->field_name;

                if (! Schema::hasColumn($tableName, $fieldName)) {
                    $missingTableFields[$tableName]['fieldMissing'][] = $fieldName;
                }
            }
        }

        return $missingTableFields;
    }
}
