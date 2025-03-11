<?php

namespace App\Services;

use App\Models\Scope;
use Illuminate\Support\Collection;

class ScopeService
{
    //create a new class instance
    public function __construct()
    {
        //
    }

    //scope list - sorted by label
    public function getScopes(int $projectId): Collection
    {
        $scopes = Scope::where('project_id', $projectId)->select('id', 'label', 'locale')->get();
        $scopes = Scope::getTranslations($scopes);

        return $scopes->sortBy('label')->pluck('label', 'id');
    }
}
