@extends('layouts.app')

@section('headline', __('task_detail_type.task_detail_types_index_headline'))
@section('subpage_content')
@php
session(['return_to_create_origin' => request()->fullUrl()]);
session(['return_to_show_origin' => request()->fullUrl()]);
session(['return_to_edit_origin' => request()->fullUrl()]);
session(['return_to_translate_origin' => request()->fullUrl()]);
session(['return_to_delete_origin' => request()->fullUrl()]);
@endphp
<div class="model-index">
    <div>
        @forelse($task_detail_types as $task_detail_type)
        @if ($loop->first)
        <ul>
            @endif
            <li>
                <span class="model-title">{{ $task_detail_type->title }}&nbsp;-&nbsp;{{ $task_detail_type->getTranslatedField('label') }}
                </span>
                <span class="model-links">
                    @php
                    $isDifferentFromOriginalLocale = app()->getLocale() != $task_detail_type->locale;
                    @endphp

                    <x-icons.action-icon
                        :action="route('task_detail_types.show', ['task_detail_type' => $task_detail_type->id] + request()->query())"
                        :title="__('task_detail_type.task_detail_types_index_show_hover')"
                        icon="fa-eye" />

                    <x-icons.action-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('task_detail_types.edit', ['task_detail_type' => $task_detail_type->id] + request()->query())"
                        :title="__('task_detail_type.task_detail_types_index_edit_hover')"
                        icon="fa-pencil-alt"
                        :disabled="$isDifferentFromOriginalLocale" />

                    <x-icons.action-icon
                        :action="route('translations.translate', ['table_name' => 'task_detail_types', 'record_id' => $task_detail_type->id] + request()->query())"
                        :title="__('task_detail_type.task_detail_types_index_translate_hover')"
                        icon="fa-language" />

                    <x-icons.confirm-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('task_detail_types.destroy', ['task_detail_type' => $task_detail_type->id] + request()->query())"
                        :message="$isDifferentFromOriginalLocale ? '' : __('task_detail_type.task_detail_types_delete_question', ['task_detail_type' => $task_detail_type->title, 'task_detail_typeId' => $task_detail_type->id])"
                        :title="__('task_detail_type.task_detail_types_index_delete_hover')"
                        :id="$task_detail_type->id"
                        :disabled="$isDifferentFromOriginalLocale" />
                </span>
            </li>
            @if ($loop->last)
        </ul>
        @endif
        @empty
        <div class="model-no-records">
            <p>{{ __('task_detail_type.task_detail_types_index_no_records_found') }}</p>
        </div>
        @endforelse
    </div>
</div>

@if($task_detail_types)
<div class="pagination justify-content-center">
    {{ $task_detail_types->links('pagination::bootstrap-4') }}
</div>
@endif

<div class="icons-action-icon">
    <x-icons.action-icon
        :action="route('task_detail_types.create')"
        title="__('task_detail_type.task_detail_types_index_new_hover')"
        icon="fa-plus-circle" />
</div>
@endsection