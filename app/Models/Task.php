<?php

namespace App\Models;

use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

#[ObservedBy([TaskObserver::class])]
class Task extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'prefix', 'is_featured', 'scope_id', 'locale', 'occurred_at'];

    protected $with = ['translations'];

    protected $casts = ['occurred_at' => 'datetime'];

    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return ['title', 'description'];
    }

    public function scope(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->belongsTo(Scope::class);
    }

    public function task_details(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->hasMany(TaskDetail::class);
    }
}
