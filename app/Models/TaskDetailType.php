<?php

namespace App\Models;

use App\Observers\TaskDetailTypeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

#[ObservedBy([TaskDetailTypeObserver::class])]
class TaskDetailType extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['title', 'label', 'locale'];

    protected $with = ['translations'];

    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return ['label'];
    }

    public function task_details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->hasMany(TaskDetail::class);
    }
}
