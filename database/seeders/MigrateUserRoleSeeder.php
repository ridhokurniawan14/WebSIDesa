<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;

class MigrateUserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role admin
        $adminRole = Role::firstOrCreate([
            'name' => 'admin'
        ]);

        // ⚠️ HANYA JALAN JIKA users.role MASIH ADA
        if (Schema::hasColumn('users', 'role')) {
            User::where('role', 'admin')->each(function ($user) use ($adminRole) {
                $user->roles()->syncWithoutDetaching([$adminRole->id]);
            });
        }
    }
}
