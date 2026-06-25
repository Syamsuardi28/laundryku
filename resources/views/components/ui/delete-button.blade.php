@props(['action'])

<form action="{{ $action }}" method="POST" class="inline">
    @csrf
    @method('DELETE')
    <button type="button" onclick="confirmDelete(this.closest('form'))" {{ $attributes->merge(['class' => 'rounded-lg px-3 py-1.5 text-xs font-semibold text-danger hover:bg-danger-50 dark:hover:bg-danger-500/10 transition-colors']) }}>
        Hapus
    </button>
</form>
