<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin';

    protected $description = 'Create the first administrator account';

    public function handle(): int
    {
        $name = $this->ask('Nama administrator');
        $email = $this->ask('Email administrator');

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Format email tidak valid.');

            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('Email tersebut sudah terdaftar.');

            return self::FAILURE;
        }

        $password = $this->secret('Password administrator');
        $confirmation = $this->secret('Konfirmasi password');

        if (empty($password) || $password !== $confirmation) {
            $this->error('Password kosong atau tidak cocok.');

            return self::FAILURE;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'administrator',
        ]);

        $this->newLine();
        $this->info('Akun administrator berhasil dibuat!');
        $this->line('User ID : '.$user->id);
        $this->line('Email   : '.$user->email);
        $this->line('Role    : '.$user->role);

        return self::SUCCESS;
    }
}
