@extends('layouts.app')

@section('headline', __('translation.translations_edit_headline'))
@section('subpage_content')
<div class="model-form">
    <div>
        <p>{{ $model_name }} (Id: {{ $record_id }})</p>
        <hr />
    </div>

    <form action="{{ route('translations.save', ['table_name' => $table_name, 'record_id' => $record_id]) }}" method="POST" id="model-form">
        @csrf

        @foreach($languages as $language)
        @php
        $isDisabled = $language == $baseRecord->locale ? true : false;
        @endphp
        @foreach($translatableFields as $field)
        @php
        $isTextarea = $field == 'description' ? true : false;
        $fieldValue = $isDisabled ? $baseRecord->$field : ($translations[$language][$field] ?? null);
        @endphp
        @if($isTextarea)
        <!-- textarea-field -->
        <x-form.textarea
            label="{{ strtoupper($language) }} - {{ ucfirst($field) }}"
            :name="'translations[' . $language . '][' . $field . ']'"
            :value="$fieldValue ?? ''"
            rows="10"
            :required="false"
            :disabled="$isDisabled" />
        @else
        <!-- text-field -->
        <x-form.input-text
            label="{{ strtoupper($language) }} - {{ ucfirst($field) }}"
            :name="'translations[' . $language . '][' . $field . ']'"
            :value="$fieldValue ?? ''"
            :required="false"
            :disabled="$isDisabled" />
        @endif
        @endforeach
        <hr />
        @endforeach

        <!-- Submit Button -->
        @can('administrate')
        <div class="submit-button">
            <button type="submit" id="toggle-edit-button" class="create-submit-button">
                {{ __('translation.translations_edit_submit_label') }}
            </button>
        </div>
        @endcan
    </form>
</div>

<div class="icons-action-icon">
    <x-icons.action-icon
        :action="session('return_to_translate_origin', url()->previous())"
        :title="__('config.history_back')"
        icon="fa-arrow-left" />
</div>
@endsection