<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_service(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $service = Service::create([
            'nama_layanan' => 'Cuci Reguler',
            'harga_per_kg' => 6000,
            'deskripsi' => 'Cuci biasa',
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('services.update', $service), [
                'nama_layanan' => 'Cuci Reguler Updated',
                'harga_per_kg' => 7500,
                'deskripsi' => 'Cuci biasa, selesai 1 hari (express)',
            ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('services.index'));

        $service->refresh();
        $this->assertSame('Cuci Reguler Updated', $service->nama_layanan);
        $this->assertSame(7500, (int)$service->harga_per_kg);
        $this->assertSame('Cuci biasa, selesai 1 hari (express)', $service->deskripsi);
    }
}
