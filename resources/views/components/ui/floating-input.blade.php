@props(['name', 'label', 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => ' '])

<div class="floating-group">
    @if($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'input-modern peer min-h-[120px] resize-y']) }}>{{ old($name, $value) }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, $value) }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'input-modern peer']) }}>
    @endif
    <label for="{{ $name }}" class="floating-label">{{ $label }}</label>
    @error($name)
        <p class="mt-2 flex items-center gap-1 text-sm text-danger animate-fade-in">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
        </p>
    @enderror
</div>
