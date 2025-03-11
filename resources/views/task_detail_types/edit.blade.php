@extends('layouts.app')

@section('headline', $isEditMode ? __('task_detail_type.task_detail_types_edit_headline') : __('task_detail_type.task_detail_types_show_headline'))
@section('subpage_content')
@php
session(['return_to_translate_origin' => request()->fullUrl()]);
@endphp
<div class="model-form">
    @php
    $isOriginalLocale = $task_detail_type->locale == session('locale') ? true : false;
    if ($isEditMode && !$isOriginalLocale) {
    $isEditMode = false;
    }
    @endphp
    <form action="{{ $isEditMode ? route('task_detail_types.update', $task_detail_type->id) : '#' }}" method="POST" id="model-form">
        @csrf
        @if($isEditMode)
        @method('PUT')
        @endif

        <!-- Title -->
        <x-form.input-text
            label="{{ __('task_detail_type.task_detail_types_create_title_label') }}"
            name="title"
            :value="$task_detail_type->title ?? ''"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- Label -->
        <x-form.input-text
            label="{{ __('task_detail_type.task_detail_types_create_label_label') }}"
            name="label"
            :value="$task_detail_type->label ?? ''"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- created_at, changed_at -->
        <x-form.created-updated
            :created_at="$task_detail_type->created_at ?? null"
            :updated_at="$task_detail_type->updated_at ?? null"
            created_label="{{ __('task_detail_type.task_detail_types_create_created_at_label') }}"
            updated_label="{{ __('task_detail_type.task_detail_types_create_updated_at_label') }}" />

        <!-- Submit Button -->
        <div class="submit-button">
            @if($isOriginalLocale)
            <button type="submit" id="toggle-edit-button" class="create-submit-button">
                {{ $isEditMode ? __('task_detail_type.task_detail_types_edit_submit_label') : __('task_detail_type.task_detail_types_show_submit_label') }}
            </button>
            @endif
            <!-- Translate Link -->
            <a href="{{ route('translations.translate', ['table_name' => 'task_detail_types', 'record_id' => $task_detail_type->id] + request()->query()) }}" id="translate-link" class="create-submit-button">{{ __('translation.translations_translate_button_label') }}</a>
        </div>
    </form>
</div>

<div class="icons-action-icon">
    @if(!$isEditMode)
    <x-icons.action-icon
        :action="route('task_detail_types.index')"
        :title="__('task_detail_type.task_detail_types_index_headline')"
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
'modelId' => $task_detail_type->id,
'modelRoute' => route('task_detail_types.edit', ['task_detail_type' => ':id']),
'isEditMode' => $isEditMode,
])
@endpush