<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeaserService
{
    public function getTeaserInfo(int $projectId = 0)
    {
        $teaserInfo = [[], []];

        $projectId = ($projectId < 0) ? 0 : $projectId;
        $projectId = $projectId ?: filter_var(session('projectId'), FILTER_VALIDATE_INT) ?? 0;

        try {
            $teaserInfo['quote'] = Inspiring::quote();
            if (! $teaserInfo['quote']) {
                $teaserInfo['quote'] = __('teaser.teaser_load_quote_error');
                Log::error(class_basename(self::class), [__('teaser.teaser_load_quote_error')]);
            }

            $task = cache('teaserTask') ?? null;

            if (is_null($task)) {
                $task = Task::join('scopes', 'tasks.scope_id', '=', 'scopes.id')
                    ->where('scopes.project_id', $projectId)
                    ->orderByDesc('tasks.occurred_at')
                    ->select('tasks.id', 'tasks.title', 'tasks.locale')
                    ->first();

                $task = Task::getTranslations($task);

                cache(['teaserTask' => $task], now()->addMinutes(10));
                $loadMessage = 'teaser.teaser_load_success';
            } else {
                $loadMessage = 'teaser.teaser_load_success_cache';
            }

            if (! $task) {
                $teaserInfo['task'] = __('teaser.teaser_load_task_error');
                Log::error(class_basename(self::class), [__('teaser.teaser_load_task_error')]);
            } else {
                $teaserInfo['task'] = $task;
            }

            Log::info(class_basename(self::class), [__($loadMessage) . ' (task: ' . $task->id . ')']);
        } catch (\Exception $e) {
            Log::error(class_basename(self::class), [__('teaser.teaser_load_error') => $e->getMessage()]);
        }

        return $teaserInfo;
    }
}
