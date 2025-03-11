@props(['label', 'placeholder' => '', 'name', 'value' => '', 'required' => false, 'disabled' => false, 'min' => null, 'max' => null, 'step' => null, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <input type="number" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}" class="{{ $classname }}-text"
        @required($required)
        @disabled($disabled)
        {{ isset($min) ? 'min=' . $min : '' }}
        {{ isset($max) ? 'max=' . $max : '' }}
        {{ isset($step) ? 'step=' . $step : '' }}
        @if($autofocus) autofocus @endif>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>