@props(['column', 'currentSort' => request('sort'), 'currentDirection' => request('direction')])

@php
    $isCurrentSort = $currentSort === $column;
    $nextDirection = $isCurrentSort && $currentDirection === 'asc' ? 'desc' : 'asc';
    
    // Merge existing query parameters (search, status, per_page, etc.) with new sort
    $url = request()->fullUrlWithQuery([
        'sort' => $column,
        'direction' => $nextDirection
    ]);
@endphp

<a href="{{ $url }}" class="group flex items-center gap-1 hover:text-primary transition-colors">
    {{ $slot }}
    <span class="flex flex-col opacity-{{ $isCurrentSort ? '100' : '40 group-hover:opacity-100' }} transition-opacity">
        <svg class="w-2 h-2 {{ $isCurrentSort && $currentDirection === 'asc' ? 'text-primary' : 'text-slate-400' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4l-8 8h16z"/></svg>
        <svg class="w-2 h-2 {{ $isCurrentSort && $currentDirection === 'desc' ? 'text-primary' : 'text-slate-400' }} -mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 20l8-8H4z"/></svg>
    </span>
</a>
