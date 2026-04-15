<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update admin user
        User::updateOrCreate(
            ['email' => 'sandeshbhandari360@gmail.com'],
            [
                'name' => 'Administrator',
                'email' => 'sandeshbhandari360@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_blocked' => false,
                'phone' => '+1234567890',
                'address' => 'Admin Office',
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: sandeshbhandari360@gmail.com');
        $this->command->info('Password: admin123');
    }
}
