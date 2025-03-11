<?php

namespace App\Models;

use App\Observers\ActivityTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

#[ObservedBy([ActivityTypeObserver::class])]
class ActivityType extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['title', 'label', 'locale'];

    protected $with = ['translations'];

    public static function translatableFields(): array
    {
        return ['label'];
    }

    public function activity_logs()
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->hasMany(ActivityLog::class);
    }
}
