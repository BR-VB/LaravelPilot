@props(['label', 'placeholder' => '', 'name', 'value' => '', 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <input type="text"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="{{ $classname }}-text"
        @required($required)
        @disabled($disabled)
        @if($autofocus) autofocus @endif>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>