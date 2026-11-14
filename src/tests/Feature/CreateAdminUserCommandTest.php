<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateAdminUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_creates_protected_super_admin(): void
    {
        $this->artisan('app:create-admin')
            ->expectsQuestion('Nama administrator', 'Super Admin Utama')
            ->expectsQuestion('Email administrator', 'superadmin@example.com')
            ->expectsQuestion('Username administrator', 'superadmin')
            ->expectsQuestion('Password administrator', 'password123')
            ->expectsQuestion('Konfirmasi password', 'password123')
            ->assertExitCode(0);

        $user = User::where('email', 'superadmin@example.com')->first();

        $this->assertNotNull($user);
        $this->assertSame('super_admin', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->is_protected);
        $this->assertTrue(
            password_verify('password123', $user->password)
        );
    }
}
