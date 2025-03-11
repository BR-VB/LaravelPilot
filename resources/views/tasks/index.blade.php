@extends('layouts.app')

@section('headline', __('task.tasks_index_headline'))
@php
session(['return_to_index_origin' => request()->fullUrl()]);
session(['return_to_create_origin' => request()->fullUrl()]);
session(['return_to_show_origin' => request()->fullUrl()]);
session(['return_to_edit_origin' => request()->fullUrl()]);
session(['return_to_translate_origin' => request()->fullUrl()]);
session(['return_to_delete_origin' => request()->fullUrl()]);
@endphp
@section('subpage_content')
<div class="model-index">
    <!-- Suchblock -->
    <form action="{{ route('tasks.index') }}" method="GET" class="search-block">
        @php
        $selectedScopeId = request('scope_id') ? request('scope_id') : '';
        @endphp
        <x-form.select
            label="{{ __('task.tasks_search_scope_label') }}"
            name="scope_id"
            :options="$scopes"
            :selected="$selectedScopeId"
            :required="false"
            :disabled="false"
            placeholder="{{ __('task.tasks_search_all_scopes') }}"
            classname="search-field" />

        <x-form.input-text
            label="{{ __('task.tasks_search_title_label') }}"
            name="title"
            :value="request('title') ?? ''"
            :required="false"
            :disabled="false"
            placeholder="{{ __('task.tasks_search_title_placeholder') }}"
            classname="search-field" />

        <div class="search-button">
            <button type="submit" class="btn btn-primary">
                {{ __('task.tasks_search_button') }}
            </button>
        </div>
    </form>

    <!-- Tasks List -->
    <div>
        @forelse($tasks as $task)
        @php
        $title = $task->getTranslatedField('title');
        if (preg_match('#<a [^>]*>(.*?)</a>#is', $title, $matches)) {
        $linkText = $matches[1];
        } else {
        $linkText = $title;
        }
        @endphp
        @if ($loop->first)
        <ul>
            @endif
            <li>
                <span class="model-title">{{ Str::limit($linkText, 50, ' ...') }}
                </span>
                <span class="model-links">
                    @php
                    $isDifferentFromOriginalLocale = app()->getLocale() != $task->locale;
                    @endphp

                    <x-icons.action-icon
                        :action="route('task_details.create', ['taskId' => $task->id] + request()->query())"
                        :title="__('task_detail.task_details_index_new_hover')"
                        icon="fa-plus-circle" />

                    <x-icons.action-icon
                        :action="route('task_details.index', ['taskId' => $task->id] + request()->except('page'))"
                        :title="__('task_detail.task_details_index_index_all_task_details')"
                        icon="fa-th-large" />

                    <x-icons.action-icon
                        :action="route('tasks.show', ['task' => $task->id] + request()->query())"
                        :title="__('task.tasks_index_show_hover')"
                        icon="fa-eye" />

                    <x-icons.action-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('tasks.edit', ['task' => $task->id] + request()->query())"
                        :title="__('task.tasks_index_edit_hover')"
                        icon="fa-pencil-alt"
                        :disabled="$isDifferentFromOriginalLocale" />

                    <x-icons.action-icon
                        :action="route('translations.translate', ['table_name' => 'tasks', 'record_id' => $task->id] + request()->query())"
                        :title="__('task.tasks_index_translate_hover')"
                        icon="fa-language" />

                    <x-icons.confirm-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('tasks.destroy', ['task' => $task->id] + request()->query())"
                        :message="$isDifferentFromOriginalLocale ? '' : __('task.tasks_delete_question', ['task' => $task->title, 'taskId' => $task->id])"
                        :title="__('task.tasks_index_delete_hover')"
                        :id="$task->id"
                        :disabled="$isDifferentFromOriginalLocale" />
                </span>
            </li>
            @if ($loop->last)
        </ul>
        @endif
        @empty
        <div class="model-no-records">
            <p>{{ __('task.tasks_index_no_records_found') }}</p>
        </div>
        @endforelse
    </div>
</div>

@if($tasks)
<div class="pagination justify-content-center">
    {{ $tasks->links('pagination::bootstrap-4') }}
</div>
@endif

<div class="icons-action-icon">
    <x-icons.action-icon
        :action="route('tasks.create')"
        :title="__('task.tasks_index_new_hover')"
        icon="fa-plus-circle" />
</div>
@endsection