<?php

namespace Tests\Feature;

use App\Models\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableManagementTest extends TestCase
{
    use RefreshDatabase;

    private function createUser(string $role): User
    {
        $user = User::create([
            'name' => ucfirst($role).' Test',
            'username' => $role.'_test',
            'email' => $role.'-test@example.com',
            'password' => 'password123',
            'role' => $role,
        ]);

        // Aktifkan akun untuk kebutuhan pengujian.
        $user->is_active = true;
        $user->is_protected = false;
        $user->save();

        return $user->refresh();
    }

    private function createTable(): Table
    {
        $table = new Table([
            'code' => 'TB-123456',
            'name' => 'Meja Test',
            'capacity' => 4,
            'location' => 'Area A',
            'is_active' => true,
        ]);

        // QR token diisi langsung karena tidak termasuk $fillable.
        $table->qr_token = str_repeat('a', 64);
        $table->save();

        return $table;
    }

    public function test_administrator_can_create_table(): void
    {
        $administrator = $this->createUser('administrator');

        $this->actingAs($administrator)
            ->post(route('tables.store'), [
                'name' => 'Meja Kantin A',
                'capacity' => 6,
                'location' => 'Area Utama',
            ])
            ->assertRedirect();

        $table = Table::where('name', 'Meja Kantin A')->first();

        $this->assertNotNull($table);
        $this->assertMatchesRegularExpression('/^TB-\d{6}$/', $table->code);
        $this->assertSame(64, strlen($table->qr_token));
        $this->assertTrue($table->is_active);
    }

    public function test_super_admin_can_create_table(): void
    {
        $superAdmin = $this->createUser('super_admin');

        $this->actingAs($superAdmin)
            ->post(route('tables.store'), [
                'name' => 'Meja Super Admin',
                'capacity' => 4,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tables', [
            'name' => 'Meja Super Admin',
            'capacity' => 4,
        ]);
    }

    public function test_tenant_cannot_access_table_management(): void
    {
        $tenant = $this->createUser('tenant');

        $this->actingAs($tenant)
            ->get(route('tables.index'))
            ->assertRedirect(route('dashboard.tenant'));
    }

    public function test_administrator_can_update_table(): void
    {
        $administrator = $this->createUser('administrator');
        $table = $this->createTable();

        $this->actingAs($administrator)
            ->withSession([
                'tables.selected_table_id' => $table->id,
            ])
            ->put(route('tables.update'), [
                'name' => 'Meja Updated',
                'capacity' => 8,
                'location' => 'Area B',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'name' => 'Meja Updated',
            'capacity' => 8,
            'location' => 'Area B',
        ]);
    }

    public function test_administrator_can_toggle_table_status(): void
    {
        $administrator = $this->createUser('administrator');
        $table = $this->createTable();

        $this->actingAs($administrator)
            ->post(route('tables.toggle-status'), [
                'table_id' => $table->id,
            ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'is_active' => false,
        ]);
    }

    public function test_administrator_can_soft_delete_and_restore_table(): void
    {
        $administrator = $this->createUser('administrator');
        $table = $this->createTable();

        $this->actingAs($administrator)
            ->post(route('tables.destroy'), [
                'table_id' => $table->id,
            ]);

        $this->assertSoftDeleted('tables', [
            'id' => $table->id,
        ]);

        $this->post(route('tables.restore'), [
            'table_id' => $table->id,
        ]);

        $this->assertDatabaseHas('tables', [
            'id' => $table->id,
            'deleted_at' => null,
        ]);
    }

    public function test_administrator_can_force_delete_table(): void
    {
        $administrator = $this->createUser('administrator');
        $table = $this->createTable();

        $table->delete();

        $this->actingAs($administrator)
            ->post(route('tables.force-delete'), [
                'table_id' => $table->id,
            ]);

        $this->assertDatabaseMissing('tables', [
            'id' => $table->id,
        ]);
    }
}
