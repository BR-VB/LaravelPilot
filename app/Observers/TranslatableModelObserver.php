<?php

namespace App\Observers;

use App\Models\TranslatableModel;
use App\Models\Translation;
use Illuminate\Support\Facades\Log;

class TranslatableModelObserver
{
    public function deleted(TranslatableModel $model)
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => 'begin', 'model' => ['table' => $model->getTable(), 'id' => $model->id]]);

        try {
            Translation::where('table_name', $model->getTable())->where('record_id', $model->id)->delete();

            Log::info(class_basename(self::class), [__FUNCTION__ => 'end']);
        } catch (\Exception $e) {
            Log::error(class_basename(self::class), [__FUNCTION__ => ['error' => $e->getMessage(), 'model' => ['table' => $model->getTable(), 'id' => $model->id]]]);
        }
    }
}
