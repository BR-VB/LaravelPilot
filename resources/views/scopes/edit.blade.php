@extends('layouts.app')

@section('headline', $isEditMode ? __('scope.scopes_edit_headline') : __('scope.scopes_show_headline'))
@section('subpage_content')
@php
session(['return_to_translate_origin' => request()->fullUrl()]);
@endphp
<div class="model-form">
    @php
    $isOriginalLocale = $scope->locale == session('locale') ? true : false;
    if ($isEditMode && !$isOriginalLocale) {
    $isEditMode = false;
    }
    @endphp
    <form action="{{ $isEditMode ? route('scopes.update', $scope->id) : '#' }}" method="POST" id="model-form">
        @csrf
        @if($isEditMode)
        @method('PUT')
        @endif

        <!-- Title -->
        <x-form.input-text
            label="{{ __('scope.scopes_create_title_label') }}"
            name="title"
            :value="$scope->title ?? ''"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- Label -->
        <x-form.input-text
            label="{{ __('scope.scopes_create_label_label') }}"
            name="label"
            :value="$scope->label ?? ''"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- Is Featured -->
        <x-form.input-checkbox
            label="{{ __('scope.scopes_create_is_featured_label') }}"
            name="is_featured"
            :checked="$scope->is_featured"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- Column -->
        <x-form.select
            label="{{ __('scope.scopes_create_column_label') }}"
            name="column"
            :options="[1=> '1', 2 => '2']"
            :selected="$scope->column"
            :required="true"
            :disabled="!$isEditMode" />

        <!-- Sort Order -->
        <x-form.input-number
            label="{{ __('scope.scopes_create_sortorder_label') }}"
            name="sortorder"
            :value="$scope->sortorder ?? ''"
            :required="true"
            :disabled="!$isEditMode"
            :min="1" />

        <!-- Background Color -->
        <x-form.input-text
            label="{{ __('scope.scopes_create_bgcolor_label') }}"
            name="bgcolor"
            :value="$scope->bgcolor ?? ''"
            :required="false"
            :disabled="!$isEditMode" />

        <!-- created_at, changed_at -->
        <x-form.created-updated
            :created_at="$scope->created_at ?? null"
            :updated_at="$scope->updated_at ?? null"
            created_label="{{ __('scope.scopes_create_created_at_label') }}"
            updated_label="{{ __('scope.scopes_create_updated_at_label') }}" />

        <!-- Submit Button -->
        <div class="submit-button">
            @if($isOriginalLocale)
            <button type="submit" id="toggle-edit-button" class="create-submit-button">
                {{ $isEditMode ? __('scope.scopes_edit_submit_label') : __('scope.scopes_show_submit_label') }}
            </button>
            @endif
            <!-- Translate Link -->
            <a href="{{ route('translations.translate', ['table_name' => 'scopes', 'record_id' => $scope->id] + request()->query()) }}" id="translate-link" class="create-submit-button">{{ __('translation.translations_translate_button_label') }}</a>
        </div>

    </form>
</div>

<div class="icons-action-icon">
    @if(!$isEditMode)
    <x-icons.action-icon
        :action="route('scopes.index')"
        :title="__('scope.scopes_index_headline')"
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
'modelId' => $scope->id,
'modelRoute' => route('scopes.edit', ['scope' => ':id']),
'isEditMode' => $isEditMode,
])
@endpush