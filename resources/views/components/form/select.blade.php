@props(['label', 'placeholder' => '', 'name', 'options' => [], 'selected' => '', 'required' => false, 'disabled' => false, 'autofocus' => false, 'classname' => 'create-field'])

<div class="{{ $classname }}">
    <label for="{{ $name }}" class="{{ $classname }}-label">{{ __($label) }}</label>
    <select id="{{ $name }}"
        name="{{ $name }}"
        class="{{ $classname }}-select"
        @required($required)
        @disabled($disabled)
        @if($autofocus) autofocus @endif>
        @if($placeholder)<option value="">{{ $placeholder }}</option>@endif
        @foreach($options as $value => $optionLabel)
        <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @error($name)
    <div class="error">{{ $message }}</div>
    @enderror
</div>