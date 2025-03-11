@extends('layouts.app')

@section('headline', $isEditMode ? __('task_detail.task_details_edit_headline') : __('task_detail.task_details_show_headline'))
@section('subpage_content')
@php
session(['return_to_translate_origin' => request()->fullUrl()]);
@endphp
<div class="model-form">
    @php
    $isOriginalLocale = $task_detail->locale == session('locale') ? true : false;
    if ($isEditMode && !$isOriginalLocale) {
    $isEditMode = false;
    }
    @endphp
    <form action="{{ $isEditMode ? route('task_details.update', $task_detail->id) : '#' }}" method="POST" id="model-form">
        @csrf
        @if($isEditMode)
        @method('PUT')
        @endif

        <!-- task_id -->
        <x-form.select
            label="{{ __('task_detail.task_details_create_task_title_label') }}"
            name="task_id"
            :options="$tasks"
            :selected="$task_detail->task_id"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- task_detail_type_id -->
        <x-form.select
            label="{{ __('task_detail.task_details_create_task_detail_type_label_label') }}"
            name="task_detail_type_id"
            :options="$task_detail_types"
            :selected="$task_detail->task_detail_type_id"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- desctiption -->
        <x-form.textarea
            label="{{ __('task_detail.task_details_create_description_label') }}"
            name="description"
            :value="$task_detail->description ?? ''"
            rows="10"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- occurred -->
        <x-form.input-datetime
            label="{{ __('task_detail.task_details_create_occurred_at_label') }}"
            name="occurred_at"
            :value="old('occurred_at', $task_detail->occurred_at ?? now())"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- created_at, changed_at -->
        <x-form.created-updated
            :created_at="$task_detail->created_at ?? null"
            :updated_at="$task_detail->updated_at ?? null"
            created_label="{{ __('task_detail.task_details_create_created_at_label') }}"
            updated_label="{{ __('task_detail.task_details_create_updated_at_label') }}" />

        <!-- Submit Button -->
        <div class="submit-button">
            @if($isOriginalLocale)
            <button type="submit" id="toggle-edit-button" class="create-submit-button">
                {{ $isEditMode ? __('task_detail.task_details_edit_submit_label') : __('task_detail.task_details_show_submit_label') }}
            </button>
            @endif
            <!-- Translate Link -->
            <a href="{{ route('translations.translate', ['table_name' => 'task_details', 'record_id' => $task_detail->id] + request()->query()) }}" id="translate-link" class="create-submit-button">{{ __('translation.translations_translate_button_label') }}</a>
        </div>
    </form>
</div>

<div class="icons-action-icon">
    @if(!$isEditMode)
    <x-icons.action-icon
        :action="route('task_details.index')"
        :title="__('task_detail.task_details_index_headline')"
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
'modelId' => $task_detail->id,
'modelRoute' => route('task_details.edit', ['task_detail' => ':id']),
'isEditMode' => $isEditMode,
])
@endpush