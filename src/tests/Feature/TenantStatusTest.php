<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_can_toggle_tenant_status(): void
    {
        $administrator = User::create([
            'name' => 'Administrator Test',
            'username' => 'admin_test',
            'email' => 'admin-test@example.com',
            'password' => 'password123',
            'role' => 'administrator',
        ]);

        $administrator->is_active = true;
        $administrator->is_protected = false;
        $administrator->save();
        $administrator->refresh();

        $tenant = Tenant::create([
            'code' => 'TN-123456',
            'name' => 'Tenant Test',
        ]);

        $this->actingAs($administrator)
            ->post(route('tenants.toggle-status'), [
                'tenant_id' => $tenant->id,
            ])
            ->assertSessionHas(
                'success',
                'Tenant berhasil dinonaktifkan.'
            );

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'is_active' => false,
        ]);

        $this->post(route('tenants.toggle-status'), [
            'tenant_id' => $tenant->id,
        ])
            ->assertSessionHas(
                'success',
                'Tenant berhasil diaktifkan.'
            );

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'is_active' => true,
        ]);
    }
}
