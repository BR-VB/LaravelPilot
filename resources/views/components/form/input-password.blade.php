@props(['label', 'placeholder' => '', 'name', 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <input type="password"
        id="{{ $name }}"
        name="{{ $name }}"
        class="{{ $classname }}-text"
        @required($required)
        @disabled($disabled)
        autocomplete="current-password"
        @if($autofocus) autofocus @endif>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>