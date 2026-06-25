@props(['title', 'subtitle' => null])

<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between animate-fade-in">
    <div>
        <h1 class="text-2xl font-semibold text-slate-900 dark:text-white sm:text-3xl">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $subtitle }}</p>
        @endif
    </div>
    @if(isset($actions))
        <div class="flex flex-wrap items-center gap-3">{{ $actions }}</div>
    @endif
</div>
