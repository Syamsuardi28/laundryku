@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Kelola User" subtitle="Akun admin dan petugas">
    <x-slot:actions>
        <a href="{{ route('users.create') }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah User
        </a>
    </x-slot:actions>
</x-ui.page-header>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4">Nama</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-sm font-bold text-primary dark:bg-primary/20">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4"><span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-semibold capitalize {{ $user->role === 'admin' ? 'bg-primary-100 text-primary dark:bg-primary/20' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300' }}">{{ $user->role }}</span></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary-50 transition-colors">Edit</a>
                            @if($user->id !== auth()->id())
                            <x-ui.delete-button :action="route('users.destroy', $user)" />
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-16 text-center text-slate-400">Belum ada user</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="border-t border-slate-100 px-6 py-4 dark:border-slate-700">{{ $users->links() }}</div>@endif
</div>
@endsection
