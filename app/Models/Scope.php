<?php

namespace App\Models;

use App\Observers\ScopeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

#[ObservedBy([ScopeObserver::class])]
class Scope extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['title', 'label', 'is_featured', 'column', 'sortorder', 'bgcolor', 'locale', 'project_id'];

    protected $attributes = ['is_featured' => false];

    protected $with = ['translations'];

    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return ['label'];
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->belongsTo(Project::class);
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->hasMany(Task::class);
    }
}
