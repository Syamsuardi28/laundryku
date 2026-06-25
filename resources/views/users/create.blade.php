@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Tambah User" />

<div class="card max-w-xl p-6">
    <form method="POST" action="{{ route('users.store') }}" class="space-y-5" data-loading>
        @csrf
        <x-ui.floating-input name="name" label="Nama Lengkap" :value="old('name')" required />
        <x-ui.floating-input name="email" label="Email" type="email" :value="old('email')" required />
        <x-ui.floating-input name="password" label="Password" type="password" required />
        <x-ui.floating-input name="password_confirmation" label="Konfirmasi Password" type="password" required />
        <x-ui.floating-select name="role" label="Role" :selected="old('role', 'petugas')" :options="['admin' => 'Admin', 'petugas' => 'Petugas']" required />
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Simpan</button>
            <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
