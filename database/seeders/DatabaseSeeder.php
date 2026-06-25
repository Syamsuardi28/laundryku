<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@laundryku.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Laundry',
            'email' => 'petugas@laundryku.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        Service::insert([
            [
                'nama_layanan' => 'Cuci Reguler',
                'harga_per_kg' => 5000,
                'deskripsi' => 'Cuci biasa, selesai 2 hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_layanan' => 'Cuci Express',
                'harga_per_kg' => 8000,
                'deskripsi' => 'Cuci kilat, selesai 1 hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_layanan' => 'Setrika Saja',
                'harga_per_kg' => 4000,
                'deskripsi' => 'Layanan setrika per kg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Customer::insert([
            [
                'nama' => 'Budi Santoso',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Aminah',
                'telepon' => '081987654321',
                'alamat' => 'Jl. Sudirman No. 25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
