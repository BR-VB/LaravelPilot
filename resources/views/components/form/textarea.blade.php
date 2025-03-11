@props(['label', 'placeholder' => '', 'name', 'value' => '', 'rows' => 10, 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <textarea id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        rows="{{ $rows }}"
        class="{{ $classname }}-textarea"
        @required($required)
        @disabled($disabled)
        @if($autofocus) autofocus @endif>{{ old($name, $value) }}</textarea>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>