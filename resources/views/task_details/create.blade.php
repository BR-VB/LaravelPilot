@extends('layouts.app')

@section('headline', __('task_detail.task_details_create_headline'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('task_details.store') }}" method="POST">
        @csrf

        <!-- task_id -->
        <x-form.select
            label="{{ __('task_detail.task_details_create_task_title_label') }}"
            name="task_id"
            :options="$tasks"
            selected="$taskId"
            :required="true"
            :disabled="false" />

        <!-- task_detail_type_id -->
        <x-form.select
            label="{{ __('task_detail.task_details_create_task_detail_type_label_label') }}"
            name="task_detail_type_id"
            :options="$task_detail_types"
            selected=""
            :required="true"
            :disabled="false" />

        <!-- desctiption -->
        <x-form.textarea
            label="{{ __('task_detail.task_details_create_description_label') }}"
            name="description"
            value=""
            rows="10"
            :required="false"
            :disabled="false" />

        <!-- occurred -->
        <x-form.input-datetime
            label="{{ __('task_detail.task_details_create_occurred_at_label') }}"
            name="occurred_at"
            :value="now()"
            :required="false"
            :disabled="false" />

        <!-- Submit Button -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('task_detail.task_details_create_submit_label') }}</button>
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