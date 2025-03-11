@props(['label', 'placeholder' => '', 'name', 'value' => '', 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <input type="email" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" class="{{ $classname }}-text"
        @required($required) @disabled($disabled) autocomplete="username" @if($autofocus) autofocus @endif>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>