<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Admin name?', 'Admin Baru');
        $email = $this->ask('Admin email?', 'admin@test.com');
        $password = $this->ask('Admin password?', 'password123');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->info("✅ Admin user created successfully!");
        $this->line("Email: {$user->email}");
        $this->line("Password: {$password}");
        $this->line("Name: {$user->name}");
        $this->line("\n🔗 Login at: http://localhost:8000/admin/login");
    }
}
