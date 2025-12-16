<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat / ambil role admin
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        // 2. Buat user admin
        $user = User::firstOrCreate(
            ['email' => 'ridho@sidesa.id'],
            [
                'name' => 'Ridho Kurniawan',
                'password' => Hash::make('segogoreng'),
                'is_active' => true,
            ]
        );

        // 3. Attach role ke user
        $user->roles()->syncWithoutDetaching([$adminRole->id]);
    }
}
