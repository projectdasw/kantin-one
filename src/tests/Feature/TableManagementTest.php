<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Canteen;
use App\Models\Floor;
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

    private function createMasterData(): array
    {
        $canteen = Canteen::create([
            'code' => 'FC',
            'name' => 'Food Court',
            'description' => 'Food Court Kampus',
            'is_active' => true,
        ]);

        $building = Building::create([
            'code' => 'GA',
            'name' => 'Gedung A',
            'description' => 'Gedung A Kampus',
            'is_active' => true,
        ]);

        $floor = Floor::create([
            'building_id' => $building->id,
            'code' => 'L1',
            'name' => 'Lantai 1',
            'description' => 'Lantai pertama',
            'is_active' => true,
        ]);

        return [
            'canteen' => $canteen,
            'building' => $building,
            'floor' => $floor,
        ];
    }

    private function createTable(): Table
    {
        $table = new Table([
            'table_number' => '01',
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
        $master = $this->createMasterData();

        $this->actingAs($administrator)
            ->post(route('tables.store'), [
                'canteen_id' => $master['canteen']->id,
                'building_id' => $master['building']->id,
                'floor_id' => $master['floor']->id,
                'name' => 'Meja A1',
                'capacity' => 6,
                'location' => 'Area Utama',
            ])
            ->assertRedirect();

        $table = Table::first();

        $this->assertNotNull($table);
        $this->assertSame('01', $table->table_number);
        $this->assertSame('FC-GA-L1-01', $table->code);
        $this->assertSame('Meja A1', $table->name);
        $this->assertSame(64, strlen($table->qr_token));
        $this->assertTrue($table->is_active);
    }

    public function test_super_admin_can_create_table(): void
    {
        $superAdmin = $this->createUser('super_admin');
        $master = $this->createMasterData();

        $this->actingAs($superAdmin)
            ->post(route('tables.store'), [
                'canteen_id' => $master['canteen']->id,
                'building_id' => $master['building']->id,
                'floor_id' => $master['floor']->id,
                'name' => 'Meja B1',
                'capacity' => 4,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tables', [
            'table_number' => '01',
            'code' => 'FC-GA-L1-01',
            'name' => 'Meja B1',
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

        $originalCode = $table->code;
        $originalTableNumber = $table->table_number;
        $originalQrToken = $table->qr_token;

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
            'code' => $originalCode,
            'table_number' => $originalTableNumber,
            'qr_token' => $originalQrToken,
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

    public function test_table_number_continues_after_previous_table_is_soft_deleted(): void
    {
        $admin = $this->createUser('administrator');
        $masterData = $this->createMasterData();

        $firstTable = new Table([
            'canteen_id' => $masterData['canteen']->id,
            'floor_id' => $masterData['floor']->id,
            'table_number' => '01',
            'code' => 'FC-GA-L1-01',
            'name' => 'Meja A1',
            'capacity' => 4,
            'is_active' => true,
        ]);

        $firstTable->qr_token = str_repeat('a', 64);
        $firstTable->save();

        $firstTable->delete();

        $response = $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $masterData['canteen']->id,
            'building_id' => $masterData['building']->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja A2',
            'capacity' => 6,
            'location' => 'Area Utara',
        ]);

        $response->assertRedirect(route('tables.index'));

        $this->assertDatabaseHas('tables', [
            'table_number' => '02',
            'code' => 'FC-GA-L1-02',
            'name' => 'Meja A2',
        ]);
    }

    public function test_table_number_restarts_for_different_canteen(): void
    {
        $admin = $this->createUser('administrator');
        $masterData = $this->createMasterData();

        $anotherCanteen = Canteen::create([
            'code' => 'KC',
            'name' => 'Kantin Central',
            'description' => 'Kantin Central Kampus',
            'is_active' => true,
        ]);

        $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $masterData['canteen']->id,
            'building_id' => $masterData['building']->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja A1',
            'capacity' => 4,
        ])->assertRedirect(route('tables.index'));

        $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $anotherCanteen->id,
            'building_id' => $masterData['building']->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja B1',
            'capacity' => 4,
        ])->assertRedirect(route('tables.index'));

        $this->assertDatabaseHas('tables', [
            'table_number' => '01',
            'code' => 'FC-GA-L1-01',
            'name' => 'Meja A1',
        ]);

        $this->assertDatabaseHas('tables', [
            'table_number' => '01',
            'code' => 'KC-GA-L1-01',
            'name' => 'Meja B1',
        ]);
    }

    public function test_administrator_cannot_create_table_with_floor_from_another_building(): void
    {
        $admin = $this->createUser('administrator');
        $masterData = $this->createMasterData();

        $anotherBuilding = Building::create([
            'code' => 'GB',
            'name' => 'Gedung B',
            'description' => 'Gedung B Kampus',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $masterData['canteen']->id,
            'building_id' => $anotherBuilding->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja A1',
            'capacity' => 4,
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseCount('tables', 0);
    }

    public function test_administrator_cannot_create_table_for_inactive_canteen(): void
    {
        $admin = $this->createUser('administrator');
        $masterData = $this->createMasterData();

        $masterData['canteen']->update([
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $masterData['canteen']->id,
            'building_id' => $masterData['building']->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja A1',
            'capacity' => 4,
        ]);

        $response->assertNotFound();

        $this->assertDatabaseCount('tables', 0);
    }

    public function test_administrator_cannot_create_table_for_inactive_building(): void
    {
        $admin = $this->createUser('administrator');
        $masterData = $this->createMasterData();

        $masterData['building']->update([
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $masterData['canteen']->id,
            'building_id' => $masterData['building']->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja A1',
            'capacity' => 4,
        ]);

        $response->assertNotFound();

        $this->assertDatabaseCount('tables', 0);
    }

    public function test_administrator_cannot_create_table_for_inactive_floor(): void
    {
        $admin = $this->createUser('administrator');
        $masterData = $this->createMasterData();

        $masterData['floor']->update([
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->post(route('tables.store'), [
            'canteen_id' => $masterData['canteen']->id,
            'building_id' => $masterData['building']->id,
            'floor_id' => $masterData['floor']->id,
            'name' => 'Meja A1',
            'capacity' => 4,
        ]);

        $response->assertNotFound();

        $this->assertDatabaseCount('tables', 0);
    }
}
