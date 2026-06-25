@props(['status'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold ' . \App\Models\Transaction::statusBadgeClass($status)]) }}>
    {{ \App\Models\Transaction::statusLabel($status) }}
</span>
