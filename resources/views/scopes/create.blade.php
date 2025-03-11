@extends('layouts.app')

@section('headline', __('scope.scopes_create_headline'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('scopes.store') }}" method="POST">
        @csrf <!-- CSRF-Schutz -->

        <!-- titel -->
        <x-form.input-text
            label="{{ __('scope.scopes_create_title_label') }}"
            name="title"
            value=""
            :required="true"
            :disabled="false" />

        <!-- label -->
        <x-form.input-text
            label="{{ __('scope.scopes_create_label_label') }}"
            name="label"
            value=""
            :required="true"
            :disabled="false" />

        <!-- is_featured -->
        <x-form.input-checkbox
            label="{{ __('scope.scopes_create_is_featured_label') }}"
            name="is_featured"
            :checked="false"
            :required="false"
            :disabled="false" />

        <!-- Column -->
        <x-form.select
            label="{{ __('scope.scopes_create_column_label') }}"
            name="column"
            :options="[1=> '1', 2 => '2']"
            selected=""
            :required="true"
            :disabled="false" />

        <!-- Sort Order -->
        <x-form.input-number
            label="{{ __('scope.scopes_create_sortorder_label') }}"
            name="sortorder"
            value=""
            :required="true"
            :disabled="false"
            :min="1" />

        <!-- Background Color -->
        <x-form.input-text
            label="{{ __('scope.scopes_create_bgcolor_label') }}"
            name="bgcolor"
            value=""
            :required="false"
            :disabled="false" />

        <!-- Absenden des Formulars -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('scope.scopes_create_submit_label') }}</button>
        </div>
    </form>
</div>
<div class="icons-action-icon">
    <x-icons.action-icon
        :action="session('return_to_create_origin', url()->previous())"
        :title="__('config.history_back')"
        icon="fa-arrow-left" />
</div>
@endsection