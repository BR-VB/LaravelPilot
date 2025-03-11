<?php

namespace App\Models;

use App\Observers\ProjectObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

#[ObservedBy([ProjectObserver::class])]
class Project extends TranslatableModel
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'is_featured', 'locale'];

    protected $attributes = ['is_featured' => false];

    protected $with = ['translations'];

    public static function translatableFields(): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return ['title', 'description'];
    }

    public function scopes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        return $this->hasMany(Scope::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        return $this->hasMany(User::class, 'default_project_id');
    }
}
