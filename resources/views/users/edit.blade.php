@extends('layouts.laundry')

@section('content')
<x-ui.page-header title="Edit User" />

<div class="card max-w-xl p-6">
    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5" data-loading>
        @csrf @method('PUT')
        <x-ui.floating-input name="name" label="Nama Lengkap" :value="old('name', $user->name)" required />
        <x-ui.floating-input name="email" label="Email" type="email" :value="old('email', $user->email)" required />
        <x-ui.floating-input name="password" label="Password Baru (opsional)" type="password" />
        <x-ui.floating-input name="password_confirmation" label="Konfirmasi Password" type="password" />
        <x-ui.floating-select name="role" label="Role" :selected="old('role', $user->role)" :options="['admin' => 'Admin', 'petugas' => 'Petugas']" required />
        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Perbarui</button>
            <a href="{{ route('users.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
