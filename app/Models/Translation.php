<?php

namespace App\Models;

use App\Observers\TranslationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

#[ObservedBy([TranslationObserver::class])]
class Translation extends Model
{
    use HasFactory;

    protected $fillable = ['table_name', 'field_name', 'record_id', 'value', 'locale'];

    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return [];
    }
}
