@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Tambah Pelanggan" subtitle="Isi formulir data pelanggan baru">
    <x-slot:actions>
        <a href="{{ route('customers.index') }}" class="btn-secondary">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </x-slot:actions>
</x-ui.page-header>

<div class="mx-auto max-w-xl">
    <div class="card p-6">
        <div class="mb-6 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-50 text-primary dark:bg-primary/20">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <div>
                <h2 class="font-semibold text-slate-900 dark:text-white">Data Pelanggan Baru</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Semua field bertanda * wajib diisi</p>
            </div>
        </div>

        <form method="POST" action="{{ route('customers.store') }}" class="space-y-5" data-loading id="form-tambah-pelanggan">
            @csrf

            @if ($errors->any())
                <div class="mb-4 rounded-xl bg-danger-50 border border-danger/20 p-4 text-sm text-danger dark:bg-danger-500/10 dark:text-danger-400">
                    <p class="font-semibold mb-1">Perbaiki kesalahan berikut:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-1">
                <label for="nama" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Nama Pelanggan <span class="text-danger">*</span>
                </label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                       placeholder="Contoh: Budi Santoso"
                       class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 @error('nama') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                       required>
                @error('nama')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="telepon" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Nomor Telepon <span class="text-danger">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}"
                           placeholder="08xxxxxxxxxx"
                           class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 @error('telepon') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                           required>
                </div>
                @error('telepon')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="alamat" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3"
                          placeholder="Alamat lengkap pelanggan (opsional)"
                          class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 transition-all focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 dark:placeholder-slate-500 resize-y @error('alamat') border-danger focus:border-danger focus:ring-danger/20 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="flex items-center gap-1.5 text-xs font-medium text-danger">
                        <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2 border-t border-slate-100 dark:border-slate-700">
                <button type="submit" class="btn-primary flex-1" id="btn-simpan-pelanggan">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pelanggan
                </button>
                <a href="{{ route('customers.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
