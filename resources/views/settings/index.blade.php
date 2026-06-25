@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Pengaturan" subtitle="Kelola preferensi aplikasi Anda" />

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2 max-w-4xl">
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Tampilan</h3>
        <div class="flex items-center justify-between rounded-xl border border-slate-200 p-4 dark:border-slate-700">
            <div>
                <p class="font-medium text-slate-900 dark:text-white">Dark Mode</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Aktifkan mode gelap untuk kenyamanan mata</p>
            </div>
            <button @click="$store.theme.toggle()" type="button"
                    class="relative h-7 w-12 rounded-full transition-colors duration-200"
                    :class="$store.theme.dark ? 'bg-primary' : 'bg-slate-300'">
                <span class="absolute top-0.5 h-6 w-6 rounded-full bg-white shadow-soft transition-transform duration-200"
                      :class="$store.theme.dark ? 'left-5' : 'left-0.5'"></span>
            </button>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Informasi Akun</h3>
        <dl class="space-y-4">
            <div class="flex justify-between rounded-xl bg-slate-50 p-4 dark:bg-slate-800/50">
                <dt class="text-sm text-slate-500">Nama</dt>
                <dd class="text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->name }}</dd>
            </div>
            <div class="flex justify-between rounded-xl bg-slate-50 p-4 dark:bg-slate-800/50">
                <dt class="text-sm text-slate-500">Email</dt>
                <dd class="text-sm font-semibold text-slate-900 dark:text-white">{{ auth()->user()->email }}</dd>
            </div>
            <div class="flex justify-between rounded-xl bg-slate-50 p-4 dark:bg-slate-800/50">
                <dt class="text-sm text-slate-500">Role</dt>
                <dd class="text-sm font-semibold capitalize text-slate-900 dark:text-white">{{ auth()->user()->role }}</dd>
            </div>
        </dl>
    </div>

    @if(auth()->user()->isAdmin())
    <div class="card p-6 lg:col-span-2">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Kelola User</h3>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Tambah dan kelola akun admin maupun petugas</p>
        <a href="{{ route('users.index') }}" class="btn-primary">Kelola User</a>
    </div>
    @endif
</div>
@endsection
