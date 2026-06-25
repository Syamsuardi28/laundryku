@props(['name', 'label', 'options' => [], 'selected' => '', 'required' => false, 'placeholder' => '-- Pilih --'])

<div class="floating-group">
    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'input-modern peer appearance-none']) }}>
        <option value="" disabled {{ old($name, $selected) === '' ? 'selected' : '' }}>{{ $placeholder }}</option>
        @foreach($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected(old($name, $selected) == $optValue)>{{ $optLabel }}</option>
        @endforeach
    </select>
    <label for="{{ $name }}" class="floating-label">{{ $label }}</label>
    @error($name)
        <p class="mt-2 flex items-center gap-1 text-sm text-danger">{{ $message }}</p>
    @enderror
</div>
