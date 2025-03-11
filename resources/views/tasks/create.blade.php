@extends('layouts.app')

@section('headline', __('task.tasks_create_headline'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <!-- scope_id -->
        <x-form.select
            label="{{ __('scope.scopes_create_scope_id_label') }}"
            name="scope_id"
            :options="$scopes"
            selected=""
            :required="true"
            :disabled="false" />

        <!-- title -->
        <x-form.input-text
            label="{{ __('task.tasks_create_title_label') }}"
            name="title"
            value=""
            :required="true"
            :disabled="false" />

        <!-- desctiption -->
        <x-form.textarea
            label="{{ __('task.tasks_create_description_label') }}"
            name="description"
            value=""
            rows="10"
            :required="false"
            :disabled="false" />

        <!-- is_featured -->
        <x-form.input-checkbox
            label="{{ __('task.tasks_create_is_featured_label') }}"
            name="is_featured"
            :checked="true"
            :required="false"
            :disabled="false" />

        <!-- icon -->
        <x-form.select
            label="{{ __('task.tasks_create_icon_label') }}"
            name="icon"
            :options="$taskIcons"
            selected=""
            :required="true"
            :disabled="false" />

        <!-- prefix -->
        <x-form.input-text
            label="{{ __('task.tasks_create_prefix_label') }}"
            name="prefix"
            value="[{{ date('d.m.') }}]"
            :required="false"
            :disabled="false" />

        <!-- occurred -->
        <x-form.input-datetime
            label="{{ __('task.tasks_create_occurred_at_label') }}"
            name="occurred_at"
            :value="now()"
            :required="false"
            :disabled="false" />

        <!-- Submit Button -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('task.tasks_create_submit_label') }}</button>
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