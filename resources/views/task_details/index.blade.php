@extends('layouts.app')

@section('headline', __('task_detail.task_details_index_headline'))
@section('subpage_content')
@php
session(['return_to_create_origin' => request()->fullUrl()]);
session(['return_to_show_origin' => request()->fullUrl()]);
session(['return_to_edit_origin' => request()->fullUrl()]);
session(['return_to_translate_origin' => request()->fullUrl()]);
session(['return_to_delete_origin' => request()->fullUrl()]);
@endphp
<div class="model-index">
    <!-- Suchblock -->
    <form action="{{ route('task_details.index') }}" method="GET" class="search-block">
        @php
        $selectedScopeId = request('scope_id') ? request('scope_id') : $scope_id;
        $selectedTaskDetailTypeId = request('task_detail_type_id') ? request('task_detail_type_id') : '';
        @endphp
        <x-form.select
            label="{{ __('task_detail.task_details_search_scope_label') }}"
            name="scope_id"
            :options="$scopes"
            :selected="$selectedScopeId"
            :required="false"
            :disabled="false"
            classname="search-field" />

        <x-form.select
            label="{{ __('task_detail.task_details_search_task_detail_type_label') }}"
            name="task_detail_type_id"
            :options="$task_detail_types"
            :selected="$selectedTaskDetailTypeId"
            :required="false"
            :disabled="false"
            placeholder="{{ __('task_detail.task_details_search_all_task_detail_types') }}"
            classname="search-field" />

        <x-form.input-text
            label="{{ __('task_detail.task_details_search_task_label') }}"
            name="task_title"
            :value="request('task_title') ?? ''"
            :required="false"
            :disabled="false"
            placeholder="{{ __('task_detail.task_details_search_title_placeholder') }}"
            classname="search-field" />

        <div class="search-button">
            <button type="submit" class="btn btn-primary">
                {{ __('task_detail.task_details_search_button') }}
            </button>
        </div>
    </form>

    <!-- Taskdetails List -->
    <div>
        @forelse($task_details as $task_detail)
        @php
        $title = $task_detail->getTranslatedField('description');
        $taskDetailTaskId = ' (Id:'. $task_detail->task_id .')';
        @endphp
        @if ($loop->first)
        <ul>
            @endif
            <li>
                <span class="model-title">Id: {{ $task_detail->id }} | {{ Str::limit($title, 50, ' ...') }}
                </span>
                <span class="model-links">
                    @php
                    $isDifferentFromOriginalLocale = app()->getLocale() != $task_detail->locale;
                    @endphp

                    <x-icons.action-icon
                        :action="route('task_details.create', ['taskId' => $task_detail->task_id] + request()->query())"
                        :title="__('task_detail.task_details_index_new_same_hover')"
                        icon="fa-plus-circle" />

                    <x-icons.action-icon
                        :action="route('task_details.show', ['task_detail' => $task_detail->id] + request()->query())"
                        :title="__('task_detail.task_details_index_show_hover')"
                        icon="fa-eye" />

                    <x-icons.action-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('task_details.edit', ['task_detail' => $task_detail->id] + request()->query())"
                        :title="__('task_detail.task_details_index_edit_hover')"
                        icon="fa-pencil-alt"
                        :disabled="$isDifferentFromOriginalLocale" />

                    <x-icons.action-icon
                        :action="route('translations.translate', ['table_name' => 'task_details', 'record_id' => $task_detail->id] + request()->query())"
                        :title="__('task_detail.task_details_index_translate_hover')"
                        icon="fa-language" />

                    <x-icons.confirm-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('task_details.destroy', ['task_detail' => $task_detail->id] + request()->query())"
                        :message="$isDifferentFromOriginalLocale ? '' : __('task_detail.task_details_delete_question', ['task_detail' => $task_detail->id, 'task_detailId' => $task_detail->id])"
                        :title="__('task_detail.task_details_index_delete_hover')"
                        :id="$task_detail->id"
                        :disabled="$isDifferentFromOriginalLocale" />
                </span>
            </li>
            @if ($loop->last)
        </ul>
        @endif
        @empty
        <div class="model-no-records">
            <p>{{ __('task_detail.task_details_index_no_records_found') }}</p>
        </div>
        @endforelse
    </div>
</div>

@if($task_details)
<div class="pagination justify-content-center">
    {{ $task_details->links('pagination::bootstrap-4') }}
</div>
@endif

<div class="icons-action-icon">
    <x-icons.action-icon
        :action="route('tasks.index')"
        :title="__('task.tasks_index_headline')"
        icon="fa-th-large" />
    <x-icons.action-icon
        :action="session('return_to_index_origin', url()->previous())"
        :title="__('config.history_back')"
        icon="fa-arrow-left" />
</div>
@endsection