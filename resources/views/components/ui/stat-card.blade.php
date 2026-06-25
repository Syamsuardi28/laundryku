@props(['label', 'value', 'icon' => 'chart', 'color' => 'primary', 'trend' => null])

@php
    $colors = [
        'primary' => 'bg-primary-50 text-primary dark:bg-primary/20 dark:text-primary-100',
        'success' => 'bg-success-50 text-success dark:bg-success-500/20 dark:text-success-500',
        'warning' => 'bg-warning-50 text-warning dark:bg-warning-500/20 dark:text-warning-500',
        'danger' => 'bg-danger-50 text-danger dark:bg-danger-500/20 dark:text-danger-500',
    ];
    $iconBg = $colors[$color] ?? $colors['primary'];
@endphp

<div {{ $attributes->merge(['class' => 'card-hover p-6 animate-slide-up']) }}>
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">{{ $value }}</p>
            @if($trend)
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $trend }}</p>
            @endif
        </div>
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $iconBg }}">
            @include('components.ui.icons.' . $icon)
        </div>
    </div>
</div>
