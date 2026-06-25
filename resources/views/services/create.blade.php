@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Tambah Layanan" />

<div class="card max-w-xl p-6">
    <form method="POST" action="{{ route('services.store') }}" class="space-y-5" data-loading>
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
        <x-ui.floating-input name="nama_layanan" label="Nama Layanan" :value="old('nama_layanan')" required />
        <x-ui.floating-input name="harga_per_kg" label="Harga per Kg (Rp)" type="number" :value="old('harga_per_kg')" min="1000" required />
        <x-ui.floating-input name="deskripsi" label="Deskripsi" type="textarea" :value="old('deskripsi')" />
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('services.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
