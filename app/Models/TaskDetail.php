<?php

namespace App\Models;

use App\Observers\TaskDetailObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

#[ObservedBy([TaskDetailObserver::class])]
class TaskDetail extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['description', 'task_id', 'task_detail_type_id', 'locale', 'occurred_at'];

    protected $with = ['translations'];

    protected $casts = ['occurred_at' => 'datetime'];

    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return ['description'];
    }

    public function task_detail_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->belongsTo(TaskDetailType::class);
    }

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->belongsTo(Task::class);
    }
}
