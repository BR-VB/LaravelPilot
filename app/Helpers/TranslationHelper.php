<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class TranslationHelper
{
    //get translations for models / tables
    public static function getTranslations(mixed $records, ?array $languages = null, ?array $translatableFields = null, bool $asCollection = true): mixed
    {
        //
        //ToDo: so far, getTranslation does not support Eloquent Collections with paginator included -> has to be added !!!
        //

        //remember origin type of $records
        $originType = self::getRecordType($records);

        //ToDo: origin type array is not yet implemented !!!
        if ($originType === 'array') {
            self::logAndThrowError(__('helper.is_not_implemented', ['records' => $records]));
        }

        [$table, $modelClass] = self::getTableAndModelClassOfObjects($originType, $records);

        if (is_null($languages)) {
            $languages = [app()->getLocale()];
        }

        $translatableFields = self::getTranslatableFields($modelClass, $translatableFields);

        $translations = self::getTranslationsArray($records, $languages, $translatableFields, $originType, $table);
        Log::info(class_basename(self::class), [__('helper.model_translations_retrieved') => ['model' => $table]]);

        return self::convertToResultType($translations, $originType, $modelClass, $asCollection);
    }

    //
    //Private Functions
    //

    //create translations array from records
    private static function getTranslationsArray(mixed $records, array $languages, array $translatableFields, string $originType, string $table): array
    {
        $translations = [];

        if ($originType === 'model') {
            $translations[] = self::getRecordTranslations($records, $languages, $translatableFields);
        } else {
            foreach ($records as $record) {
                $translations[] = self::getRecordTranslations($record, $languages, $translatableFields);
            }
        }

        return $translations;
    }

    //get translations for a single record
    private static function getRecordTranslations(mixed $record, array $languages, array $translatableFields): array
    {
        $result = $record->toArray();

        if (count($languages) === 1) {
            $recordTranslations = $record->translations->where('locale', $languages[0])->pluck('value', 'field_name');
            if ($record->locale != $languages[0]) {
                foreach ($translatableFields as $field) {
                    $result[$field] = $recordTranslations->get($field) ?? null;
                }
            }
        } else {
            foreach ($translatableFields as $field) {
                $fieldTranslations = [];

                foreach ($languages as $language) {
                    $recordTranslations = $record->translations->where('locale', $language)->pluck('value', 'field_name');
                    if ($record->locale != $language) {
                        $fieldTranslations[$language] = $recordTranslations->get($field) ?? null;
                    } else {
                        $fieldTranslations[$language] = $result[$field];
                    }
                }

                $result[$field] = $fieldTranslations;
            }
        }

        return $result;
    }

    //convert translations array to result type
    private static function convertToResultType(array $translations, string $originType, string $modelClass, bool $asCollection): mixed
    {
        if ($originType === 'model') {
            $translatedRecord = new $modelClass;
            foreach ($translations[0] as $key => $value) {
                $translatedRecord->{$key} = $value;
            }

            return $translatedRecord;
        } elseif ($originType === 'array') {
            return $translations;
        } elseif ($asCollection) {
            return collect($translations)->map(function ($translatedData) use ($modelClass) {
                $modelInstance = new $modelClass;
                foreach ($translatedData as $key => $value) {
                    $modelInstance->{$key} = $value;
                }

                return $modelInstance;
            });
        }

        //default ... result remains unchanged (= array)
        return $translations;
    }

    //read translatable fields from model class
    private static function getTranslatableFields(string $modelClass, ?array $translatableFields): array
    {
        if (method_exists($modelClass, 'translatableFields')) {
            $translatableFieldsFromModel = $modelClass::translatableFields();
        } else {
            self::logAndThrowError(__('helper.method_translatable_fields_not_defined', ['model' => '{$modelClass}Model']));
        }

        if (is_null($translatableFields)) {
            return $translatableFieldsFromModel;
        }

        $notTranslatableFields = array_diff($translatableFields, $translatableFieldsFromModel);
        if (! empty($notTranslatableFields)) {
            $translatableFields = array_diff($translatableFields, $notTranslatableFields);
            Log::warning(class_basename(self::class), [__('helper.not_translatable_fields_given', ['fields' => $notTranslatableFields])]);
        }

        return $translatableFields;
    }

    //get table name and model class from record
    private static function getTableAndModelClassOfObjects(string $originType, mixed $records): array
    {
        if ($originType === 'model') {
            $record = $records;
        } else {
            $record = $records->first();
        }

        if (! is_object($record)) {
            self::logAndThrowError(__('helper.no_valid_record_type', ['record' => $record]));
        }

        if (! method_exists($record, 'getTable')) {
            self::logAndThrowError(__('helper.no_valid_record_type', ['record' => $record]));
        }

        $table = $record->getTable();
        if (! is_string($table) || empty($table)) {
            self::logAndThrowError(__('helper.no_valid_record_type', ['record' => $record]));
        }

        $modelClass = get_class($record);
        if (! class_exists($modelClass)) {
            self::logAndThrowError(__('helper.no_valid_record_type', ['record' => $record]));
        }

        return [$table, $modelClass];
    }

    //remember origin records type
    private static function getRecordType(mixed $records): string
    {
        if (is_object($records) && method_exists($records, 'getTable')) {
            $originType = 'model';
        } elseif (is_array($records)) {
            $originType = 'array';
        } elseif ($records instanceof \Illuminate\Support\Collection) {
            $originType = 'collection';
        } else {
            self::logAndThrowError(__('helper.no_valid_record_type', ['records' => $records]));
        }

        return $originType;
    }

    //log error and throw InvalidArgumentException
    private static function logAndThrowError(string $message): void
    {
        Log::error(class_basename(self::class), [$message]);
        throw new InvalidArgumentException($message);
    }
}
