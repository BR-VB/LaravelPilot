<?php

namespace App\Http\Controllers\App;

use App\Models\Translation;
use App\Services\LanguageService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TranslationController extends Controller
{
    protected array $tableToModelMapping = [
        'projects' => \App\Models\Project::class,
        'scopes' => \App\Models\Scope::class,
        'tasks' => \App\Models\Task::class,
        'task_details' => \App\Models\TaskDetail::class,
        'task_detail_types' => \App\Models\TaskDetailType::class,
        'activity_types' => \App\Models\ActivityType::class,
    ];

    public function __construct(protected LanguageService $languageService)
    {
        parent::__construct();
    }

    //destroy - DELETE
    public function destroy(Translation $translation): RedirectResponse
    {
        try {
            $translation->delete();

            Log::info($this->className, [__FUNCTION__ => $translation->id]);
            return redirect()->back()->withSuccess(__('translation.translations_delete_success_message'));
        } catch (QueryException $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('translation.translations_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $translation->id,
            ]);

            return redirect()->back()->withError(__('translation.translations_delete_error_message') . $e->getMessage())->withInput();
        }
    }

    //save - INSERT or UPDATE ( no model-binding here (!) )
    public function save(Request $request, string $table_name, string $record_id, ?string $field_name = null): RedirectResponse
    {
        $modelClass = $this->getModelClassFromTable($table_name);
        $baseRecord = $modelClass::where('id', $record_id)->first();

        if (!$baseRecord) {
            return redirect()->back()->withErrors(__('translation.translations_save_error_base_record_not_found'));
        }

        $translations = $request->input('translations');

        foreach ($translations as $language => $translationFields) {
            if (strtolower($language) == strtolower($baseRecord->locale)) {
                //check done for security ... in case something went wrong in html-form ...
                continue;
            }

            foreach ($translationFields as $fieldName => $fieldValue) {
                $existingTranslation = Translation::where('table_name', $table_name)
                    ->where('record_id', $record_id)
                    ->where('field_name', $fieldName)
                    ->where('locale', strtolower($language))
                    ->first();

                if ($existingTranslation) {
                    if ($fieldValue === null) {
                        $existingTranslation->delete();
                    } else {
                        $existingTranslation->update(['value' => $fieldValue]);
                    }
                } else {
                    if ($fieldValue !== null) {
                        Translation::create([
                            'table_name' => $table_name,
                            'record_id' => $record_id,
                            'field_name' => $fieldName,
                            'locale' => strtolower($language),
                            'value' => $fieldValue,
                        ]);
                    }
                }
            }
        }

        return redirect()->back()->withSuccess(__('translation.translations_save_success_message'));
    }

    //translate - for all languages
    public function translate(string $table_name, string $record_id, ?string $field_name = null): View
    {
        Log::info($this->className, [__FUNCTION__]);

        //all supported languages
        $languages = $this->languageService->getAvailableLanguages();
        rsort($languages);

        //get all translateable fields for table_name from model class
        $modelClass = $this->getModelClassFromTable($table_name);
        $translatableFields = $this->getTranslatableFieldsFromModelClass($modelClass);

        //if a single field should be translated only ...
        if ($field_name) {
            $translatableFields = array_values(array_filter($translatableFields, function ($fieldItem) use ($field_name) {
                return $fieldItem === $field_name;
            }));
        }

        $baseRecord = [];
        if ($modelClass) {
            $baseRecord = $modelClass::find($record_id);
        }

        $translationsCollection = Translation::where('table_name', $table_name)->where('record_id', $record_id)
            ->when($field_name, function ($query, $field_name) {
                return $query->where('field_name', $field_name);
            })
            ->orderBy('table_name')->orderBy('record_id')->orderBy('locale', 'desc')->orderBy('field_name')
            ->get();

        //convert collection to array
        $translations = $translationsCollection->reduce(function ($groupedTranslations, $item) {
            $groupedTranslations[$item['locale']][$item['field_name']] = $item['value'];
            return $groupedTranslations;
        }, []);

        return view('translations.edit', [
            'projectTitle' => session('projectTitle') ?? '',
            'model_name' => class_basename($modelClass),
            'table_name' => $table_name,
            'record_id' => $record_id,
            'field_name' => $field_name,
            'languages' => $languages,
            'translatableFields' => $translatableFields,
            'translations' => $translations,
            'baseRecord' => $baseRecord,
        ]);
    }

    //index - show all translations
    public function index(Request $request): View
    {
        Log::info($this->className, [__FUNCTION__]);

        $sTableName = $request->input('sTableName') ?? 'tasks';
        $projectId = session('projectId') ?? 0;

        $translatableTables = array_keys($this->tableToModelMapping);
        $translatableTables = array_combine($translatableTables, $translatableTables);

        //secure: only translations for actual selected project are retrieved
        $translations = Translation::query()
            ->when($sTableName, fn($query) => $query->where('translations.table_name', $sTableName))
            ->when($sTableName, function ($query) use ($projectId, $sTableName) {
                return match ($sTableName) {
                    'projects' => $query->whereExists(function ($subQuery) use ($projectId) {
                        $subQuery->select(DB::raw(1))
                            ->from('projects')
                            ->whereColumn('translations.record_id', 'projects.id')
                            ->where('projects.id', $projectId);
                    }),

                    'scopes' => $query->whereExists(function ($subQuery) use ($projectId) {
                        $subQuery->select(DB::raw(1))
                            ->from('scopes')
                            ->whereColumn('translations.record_id', 'scopes.id')
                            ->where('scopes.project_id', $projectId);
                    }),

                    'tasks' => $query->whereExists(function ($subQuery) use ($projectId) {
                        $subQuery->select(DB::raw(1))
                            ->from('tasks')
                            ->join('scopes', 'tasks.scope_id', '=', 'scopes.id')
                            ->whereColumn('translations.record_id', 'tasks.id')
                            ->where('scopes.project_id', $projectId);
                    }),

                    'task_details' => $query->whereExists(function ($subQuery) use ($projectId) {
                        $subQuery->select(DB::raw(1))
                            ->from('task_details')
                            ->join('tasks', 'task_details.task_id', '=', 'tasks.id')
                            ->join('scopes', 'tasks.scope_id', '=', 'scopes.id')
                            ->whereColumn('translations.record_id', 'task_details.id')
                            ->where('scopes.project_id', $projectId);
                    }),

                    'activity_types' => $query->whereExists(function ($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('activity_types')
                            ->whereColumn('translations.record_id', 'activity_types.id');
                    }),

                    'task_detail_types' => $query->whereExists(function ($subQuery) {
                        $subQuery->select(DB::raw(1))
                            ->from('task_detail_types')
                            ->whereColumn('translations.record_id', 'task_detail_types.id');
                    }),

                    default => $query,
                };
            })
            ->orderBy('translations.table_name')
            ->orderBy('translations.record_id')
            ->orderBy('translations.field_name')
            ->orderBy('translations.locale')
            ->paginate(8)
            ->appends($request->query());

        return view('translations.index', [
            'projectTitle' => session('projectTitle') ?? '',
            'translatableTables' => $translatableTables,
            'translations' => $translations,
        ]);
    }

    //==== Private Functions ====
    private function getModelClassFromTable(string $table_name): ?string
    {
        $modelClass = $this->tableToModelMapping[$table_name] ?? null;
        if (class_exists($modelClass)) {
            return $modelClass;
        }

        return null;
    }

    private function getTranslatableFieldsFromModelClass(?string $modelClass): array
    {
        if ($modelClass && class_exists($modelClass)) {
            return $modelClass::translatableFields();
        }

        return [];
    }
}
