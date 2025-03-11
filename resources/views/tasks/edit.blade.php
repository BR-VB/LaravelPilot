@extends('layouts.app')

@section('headline', $isEditMode ? __('task.tasks_edit_headline') : __('task.tasks_show_headline'))
@section('subpage_content')
@php
session(['return_to_translate_origin' => request()->fullUrl()]);
@endphp
<div class="model-form">
    @php
    $isOriginalLocale = $task->locale == session('locale') ? true : false;
    if ($isEditMode && !$isOriginalLocale) {
    $isEditMode = false;
    }
    @endphp
    <form action="{{ $isEditMode ? route('tasks.update', $task->id) : '#' }}" method="POST" id="model-form">
        @csrf
        @if($isEditMode)
        @method('PUT')
        @endif

        <!-- scope_id -->
        <x-form.select
            label="{{ __('scope.scopes_create_scope_id_label') }}"
            name="scope_id"
            :options="$scopes"
            :selected="$task->scope_id"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- title -->
        <x-form.input-text
            label="{{ __('task.tasks_create_title_label') }}"
            name="title"
            :value="$task->title ?? ''"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- desctiption -->
        <x-form.textarea
            label="{{ __('task.tasks_create_description_label') }}"
            name="description"
            :value="$task->description ?? ''"
            rows="10"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- Is Featured -->
        <x-form.input-checkbox
            label="{{ __('task.tasks_create_is_featured_label') }}"
            name="is_featured"
            :checked="$task->is_featured"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- icon -->
        <x-form.select
            label="{{ __('task.tasks_create_icon_label') }}"
            name="icon"
            :options="$taskIcons"
            :selected="$task->icon ?? ''"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- prefix -->
        <x-form.input-text
            label="{{ __('task.tasks_create_prefix_label') }}"
            name="prefix"
            :value="$task->prefix ?? ''"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- occurred -->
        <x-form.input-datetime
            label="{{ __('task.tasks_create_occurred_at_label') }}"
            name="occurred_at"
            :value="old('occurred_at', $task->occurred_at ?? now())"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- created_at, changed_at -->
        <x-form.created-updated
            :created_at="$task->created_at ?? null"
            :updated_at="$task->updated_at ?? null"
            created_label="{{ __('task.tasks_create_created_at_label') }}"
            updated_label="{{ __('task.tasks_create_updated_at_label') }}" />

        <!-- Submit Button -->
        <div class="submit-button">
            @if($isOriginalLocale)
            <button type="submit" id="toggle-edit-button" class="create-submit-button">
                {{ $isEditMode ? __('task.tasks_edit_submit_label') : __('task.tasks_show_submit_label') }}
            </button>
            @endif
            <!-- Translate Link -->
            <a href="{{ route('translations.translate', ['table_name' => 'tasks', 'record_id' => $task->id] + request()->query()) }}" id="translate-link" class="create-submit-button">{{ __('translation.translations_translate_button_label') }}</a>
        </div>
    </form>
</div>

<div class="icons-action-icon">
    @if(!$isEditMode)
    <x-icons.action-icon
        :action="route('tasks.index')"
        :title="__('task.tasks_index_headline')"
        icon="fa-th-large" />
    @endif
    <x-icons.action-icon
        :action="session('return_to_show_origin', url()->previous())"
        :title="__('config.history_back')"
        icon="fa-arrow-left" />
</div>
@endsection

@push('scripts')
@include('scripts.model-scripts', [
'modelId' => $task->id,
'modelRoute' => route('tasks.edit', ['task' => ':id']),
'isEditMode' => $isEditMode,
])
@endpush