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

{{-- Search Bar --}}
<div class="card mb-6 p-4">
    <form method="GET" class="flex flex-col gap-3 sm:flex-row items-center" id="form-search-user" x-data x-ref="form">
        <div class="flex items-center gap-2">
            <span class="text-sm font-semibold text-slate-500">Tampilkan</span>
            <select name="per_page" @change="$refs.form.submit()" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/20">
                @foreach([10, 25, 50, 100] as $val)
                <option value="{{ $val }}" @selected(request('per_page', 10) == $val)>{{ $val }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="relative flex-1 w-full">
            <svg class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" id="search-user" value="{{ request('search') }}" placeholder="Cari nama atau email..."
                   @input.debounce.500ms="$refs.form.submit()"
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-9 pr-4 text-sm transition-all focus:border-primary focus:bg-white focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200 dark:placeholder-slate-400">
        </div>
        <button type="submit" class="btn-secondary hidden sm:flex" id="btn-cari-user">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Cari
        </button>
        @if(request('search'))
        <a href="{{ route('users.index') }}" class="btn-secondary" id="btn-reset-search">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reset
        </a>
        @endif
    </form>
</div>

<div class="card overflow-hidden">
    @if($users->isNotEmpty())
    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-3 dark:border-slate-700">
        <p class="text-sm text-slate-500 dark:text-slate-400">
            Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $users->firstItem() }}-{{ $users->lastItem() }}</span>
            dari <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $users->total() }}</span> pengguna
        </p>
    </div>
    @endif
    <div class="overflow-x-auto">
        <table class="table-modern w-full text-sm">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-left"><x-ui.sortable-header column="name">Nama</x-ui.sortable-header></th>
                    <th class="px-6 py-4 text-left"><x-ui.sortable-header column="email">Email</x-ui.sortable-header></th>
                    <th class="px-6 py-4 text-left"><x-ui.sortable-header column="role">Role</x-ui.sortable-header></th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-slate-600 dark:text-slate-300">
                @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary-50 text-sm font-bold text-primary dark:bg-primary/20">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <span class="font-semibold text-slate-900 dark:text-white">@highlight($user->name, request('search'))</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">@highlight($user->email, request('search'))</td>
                    <td class="px-6 py-4"><span class="inline-flex rounded-lg px-2.5 py-1 text-xs font-semibold capitalize {{ $user->role === 'admin' ? 'bg-primary-100 text-primary dark:bg-primary/20' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300' }}">@highlight($user->role, request('search'))</span></td>
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
