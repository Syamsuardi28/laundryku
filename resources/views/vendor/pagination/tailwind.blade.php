@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-between gap-4">
    <p class="text-sm text-slate-500 dark:text-slate-400">
        Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $paginator->total() }}</span>
    </p>
    <div class="flex items-center gap-1">
        @if ($paginator->onFirstPage())
            <span class="rounded-xl px-3 py-2 text-sm text-slate-300 dark:text-slate-600 cursor-not-allowed">← Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors">← Prev</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-slate-400">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="rounded-xl bg-primary px-3.5 py-2 text-sm font-semibold text-white shadow-soft">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="rounded-xl px-3.5 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors">Next →</a>
        @else
            <span class="rounded-xl px-3 py-2 text-sm text-slate-300 dark:text-slate-600 cursor-not-allowed">Next →</span>
        @endif
    </div>
</nav>
@endif
