<?php

namespace App\Models;

use App\Observers\TranslatableModelObserver;
use App\Traits\TranslatableMethods;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

#[ObservedBy([TranslatableModelObserver::class])]
abstract class TranslatableModel extends Model
{
    use TranslatableMethods;

    //define models translatable fields
    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return [];
    }

    //for direct usage in queries
    public function scopeWithTranslations($query, ?string $locale = null, ?string $field = null, ?string $searchTerm = null)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $locale = $locale ?? app()->getLocale();

        if (! is_null($field)) {
            if (! in_array($field, static::translatableFields())) {
                Log::error(class_basename(self::class), [__('config.field_is_not_translateable', ['field' => $field])]);
                throw new \InvalidArgumentException(__('config.field_is_not_translateable', ['field' => $field]));
            }
        }

        return $query->with(['translations' => function ($query) use ($locale, $field, $searchTerm) {
            $query->where('locale', $locale);
            if (! is_null($field)) {
                $query->where('field_name', $field);
            }
            if (! is_null($searchTerm)) {
                $query->where('value', 'like', '%' . $searchTerm . '%');
            }
        }]);
    }

    //for prgrammatic usage
    public function translations()
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => $this->getTable()]);

        return $this->hasMany(Translation::class, 'record_id', 'id')
            ->where('table_name', $this->getTable());
    }

    public function getTranslatedField(string $field): ?string
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! in_array($field, static::translatableFields())) {
            Log::error(class_basename(self::class), [__('config.field_is_not_translateable', ['field' => $field])]);
            throw new \InvalidArgumentException(__('config.field_is_not_translateable', ['field' => $field]));
        }

        $locale = app()->getLocale();

        if ($this->locale === $locale) {
            return $this->$field;
        }

        $translation = $this->translations
            ->where('field_name', $field)
            ->where('locale', $locale)
            ->first();

        return $translation->value ?? null;
    }

    public function setTranslatedField(string $field, string $value): void
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $locale = app()->getLocale();
        $this->translations()->updateOrCreate(['field' => $field, 'locale' => $locale], ['value' => $value]);
    }
}
