<?php

namespace App\Models;

use App\Observers\ActivityLogObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

#[ObservedBy([ActivityLogObserver::class])]
class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['module', 'table_name', 'field_name', 'value', 'description', 'activity_type_id', 'user_id', 'locale'];

    public static function translatableFields(): array
    {
        return [];
    }

    public function activity_type()
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->belongsTo(ActivityType::class);
    }
}
