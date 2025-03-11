@props(['label', 'name', 'checked' => false, 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <div class="{{ $classname }}-checkbox-container">
        <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
        <input type="hidden" name="{{ $name }}" value="0">
        <input type="checkbox" id="{{ $name }}" name="{{ $name }}" class="{{ $classname }}-checkbox" value="1"
            {{ old($name, $checked) ? 'checked' : '' }}
            @required($required)
            @disabled($disabled)
            @if($autofocus) autofocus @endif>
        @error($name)
        <div class="error">{{ $message }}</div>
        @enderror
    </div>
</div>