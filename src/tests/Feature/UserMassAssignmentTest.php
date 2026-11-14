<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserMassAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_status_and_protection_cannot_be_changed_through_mass_assignment(): void
    {
        $user = User::create([
            'name' => 'Administrator Test',
            'username' => 'admin_test',
            'email' => 'admin-test@example.com',
            'password' => 'password123',
            'role' => 'administrator',
            'is_active' => false,
            'is_protected' => true,
        ]);

        $user->refresh();

        $this->assertTrue($user->is_active);
        $this->assertFalse($user->is_protected);

        $user->fill([
            'is_active' => false,
            'is_protected' => true,
        ]);

        $user->save();
        $user->refresh();

        $this->assertTrue($user->is_active);
        $this->assertFalse($user->is_protected);
    }
}
