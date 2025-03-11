<?php

namespace App\Traits;

use App\Helpers\TranslationHelper;
use App\Models\TranslatableModel;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

trait TranslatableMethods
{
    public static function getTranslations(mixed $records, ?array $languages = null, ?array $translatableFields = null, bool $asCollection = true): mixed
    {
        //no object given
        if (is_null($records)) {
            return $records;
        }

        //empty collection given
        if ($records instanceof \Illuminate\Support\Collection && $records->isEmpty()) {
            return $records;
        }

        [$languages, $translatableFields] = self::validateParams($records, $languages, $translatableFields);

        Log::info(class_basename(self::class), [__FUNCTION__]);

        return TranslationHelper::getTranslations($records, $languages, $translatableFields, $asCollection);
    }

    //
    //Private Functions
    //

    //validate parameters
    private static function validateParams(mixed $records, ?array $languages = null, ?array $translatableFields = null): array
    {
        $modelClass = self::validateRecords($records);

        if (is_null($languages)) {
            $languages = [app()->getLocale()];
        }

        if (is_null($translatableFields) && ! is_null($modelClass)) {
            if (method_exists($modelClass, 'translatableFields')) {
                $translatableFields = $modelClass::translatableFields();
            } else {
                self::logAndThrowError(__('helper.method_translatable_fields_not_defined', ['model' => '{$modelClass}Model']));
            }
        }

        return [$languages, $translatableFields];
    }

    //validate records
    private static function validateRecords(mixed $records): ?string
    {
        if ($records instanceof \Illuminate\Support\Collection) {
            if ($records->isEmpty()) {
                return null;
            }

            $modelClass = get_class($records->first());

            foreach ($records as $record) {
                if (! $record instanceof TranslatableModel || get_class($record) !== $modelClass) {
                    self::logAndThrowError(__('helper.no_valid_record_type', ['records' => $records]));
                }
            }

            return $modelClass;
        }

        if (is_object($records)) {
            if (! $records instanceof TranslatableModel) {
                self::logAndThrowError(__('helper.no_valid_record_type', ['records' => $records]));
            }

            return get_class($records);
        }

        self::logAndThrowError(__('helper.no_valid_record_type', ['records' => $records]));

        return null;
    }

    //log error and throw InvalidArgumentException
    private static function logAndThrowError(string $message): void
    {
        Log::error(class_basename(self::class), [$message]);
        throw new InvalidArgumentException($message);
    }
}
