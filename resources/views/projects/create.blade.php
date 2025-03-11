@extends('layouts.app')

@section('headline', __('project.projects_create_headline'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('projects.store') }}" method="POST">
        @csrf

        <!-- title -->
        <x-form.input-text
            label="{{ __('project.projects_create_title_label') }}"
            name="title"
            value=""
            :required="true"
            :disabled="false" />

        <!-- desctiption -->
        <x-form.textarea
            label="{{ __('project.projects_create_description_label') }}"
            name="description"
            value=""
            rows="10"
            :required="false"
            :disabled="false" />

        <!-- is_featured -->
        <x-form.input-checkbox
            label="{{ __('project.projects_create_is_featured_label') }}"
            name="is_featured"
            :checked="false"
            :required="false"
            :disabled="false" />

        <!-- Submit Button -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('project.projects_create_submit_label') }}</button>
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