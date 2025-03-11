@extends('layouts.app')

@section('headline', __('task_detail_type.task_detail_types_create_headline'))
@section('subpage_content')
<div class="model-form">
    <form action="{{ route('task_detail_types.store') }}" method="POST">
        @csrf <!-- CSRF-Schutz -->

        <!-- titel -->
        <x-form.input-text
            label="{{ __('task_detail_type.task_detail_types_create_title_label') }}"
            name="title"
            value=""
            :required="true"
            :disabled="false" />

        <!-- label -->
        <x-form.input-text
            label="{{ __('task_detail_type.task_detail_types_create_label_label') }}"
            name="label"
            value=""
            :required="true"
            :disabled="false" />

        <!-- Absenden des Formulars -->
        <div class="submit-button">
            <button type="submit" class="create-submit-button">{{ __('task_detail_type.task_detail_types_create_submit_label') }}</button>
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