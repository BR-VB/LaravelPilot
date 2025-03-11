@extends('layouts.app')

@section('headline', __('translation.translations_index_headline'))
@section('subpage_content')
@php
session(['return_to_translate_origin' => request()->fullUrl()]);
session(['return_to_delete_origin' => request()->fullUrl()]);
@endphp
<div class="model-index">
    <!-- Suchblock -->
    <form action="{{ route('translations.index') }}" method="GET" class="search-block">
        @php
        $selectedTableName = request('sTableName') ? request('sTableName') : 'tasks';
        @endphp
        <x-form.select
            label="{{ __('translation.translations_search_table_name_label') }}"
            name="sTableName"
            :options="$translatableTables"
            :selected="$selectedTableName"
            :required="false"
            :disabled="false"
            placeholder="{{ __('translation.translations_search_all_tables') }}"
            classname="search-field" />

        <div class="search-button">
            <button type="submit" class="btn btn-primary">
                {{ __('translation.translations_search_button') }}
            </button>
        </div>
    </form>

    <!-- Translations List -->
    <div>
        @forelse($translations as $translation)
        @php
        $isOriginalLocale = $translation->locale == session('locale') ? true : false;
        $isDifferentFromOriginalLocale = app()->getLocale() != $translation->locale;
        @endphp
        @if ($loop->first)
        <ul>
            @endif
            <li>
                <span class="model-title">{{ $translation->table_name }} ({{ $translation->record_id }}): {{ $translation->locale}} - {{ $translation->field_name }}</span>
                <span class="model-links">
                    <x-icons.action-icon
                        :action="route('translations.translate', ['table_name'=> $translation->table_name, 'record_id' => $translation->record_id, 'field_name' => $translation->field_name] + request()->query())"
                        :title=" __('translation.translations_index_edit_hover')"
                        icon="fa-pencil-alt"
                        :disabled="$isDifferentFromOriginalLocale" />

                    <x-icons.confirm-icon
                        :action="route('translations.destroy', ['translation' => $translation->id])"
                        :message="__('translation.translations_delete_question', ['translation' => $translation->table_name . '/' . $translation->record_id . '/' . $translation->field_name, 'translationId' => $translation->id] + request()->query())"
                        :title="__('translation.translations_index_delete_hover')"
                        :id="$translation->id"
                        :disabled="$isDifferentFromOriginalLocale" />
                </span>
            </li>
            @if ($loop->last)
        </ul>
        @endif
        @empty
        <div class="model-no-records">
            <p>{{ __('translation.translations_index_no_records_found') }}</p>
        </div>
        @endforelse
    </div>
</div>

@if($translations)
<div class="pagination justify-content-center">
    {{ $translations->links('pagination::bootstrap-4') }}
</div>
@endif
@endsection