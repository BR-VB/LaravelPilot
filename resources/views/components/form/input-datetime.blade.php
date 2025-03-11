@props(['label', 'placeholder' => '', 'name', 'value' => '', 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <input type="datetime-local"
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name,  $value ? \Carbon\Carbon::parse($value)->format('Y-m-d\TH:i:s') : '') }}"
        class="{{ $classname }}-text"
        step="1"
        @required($required)
        @disabled($disabled)
        @if($autofocus) autofocus @endif>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>