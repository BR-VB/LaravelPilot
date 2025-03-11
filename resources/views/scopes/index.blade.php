@extends('layouts.app')

@section('headline', __('scope.scopes_index_headline'))
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
        @forelse($scopes as $scope)
        @if ($loop->first)
        <ul>
            @endif
            <li>
                <span class="model-title">{{ $scope->title }}&nbsp;-&nbsp;{{ $scope->getTranslatedField('label') }}
                </span>
                <span class="model-links">
                    @php
                    $isDifferentFromOriginalLocale = app()->getLocale() != $scope->locale;
                    @endphp

                    <x-icons.action-icon
                        :action="route('scopes.show', ['scope' => $scope->id] + request()->query())"
                        :title="__('scope.scopes_index_show_hover')"
                        icon="fa-eye" />

                    <x-icons.action-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('scopes.edit', ['scope' => $scope->id] + request()->query())"
                        :title="__('scope.scopes_index_edit_hover')"
                        icon="fa-pencil-alt"
                        :disabled="$isDifferentFromOriginalLocale" />

                    <x-icons.action-icon
                        :action="route('translations.translate', ['table_name' => 'scopes', 'record_id' => $scope->id] + request()->query())"
                        :title="__('scope.scopes_index_translate_hover')"
                        icon="fa-language" />

                    <x-icons.confirm-icon
                        :action="$isDifferentFromOriginalLocale ? '#' : route('scopes.destroy', ['scope' => $scope->id] + request()->query())"
                        :message="$isDifferentFromOriginalLocale ? '' : __('scope.scopes_delete_question', ['scope' => $scope->title, 'scopeId' => $scope->id])"
                        :title="__('scope.scopes_index_delete_hover')"
                        :id="$scope->id"
                        :disabled="$isDifferentFromOriginalLocale" />
                </span>
            </li>
            @if ($loop->last)
        </ul>
        @endif
        @empty
        <div class="model-no-records">
            <p>{{ __('scope.scopes_index_no_records_found') }}</p>
        </div>
        @endforelse
    </div>
</div>

@if($scopes)
<div class="pagination justify-content-center">
    {{ $scopes->links('pagination::bootstrap-4') }}
</div>
@endif

<div class="icons-action-icon">
    <x-icons.action-icon
        :action="route('scopes.create')"
        title="__('scope.scopes_index_new_hover')"
        icon="fa-plus-circle" />
</div>
@endsection