<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard.view',

            'profil.view',
            'profil.update',
            'visi-misi.view',
            'visi-misi.update',
            'sejarah.view',
            'sejarah.update',
            'perangkat.view',
            'perangkat.create',
            'perangkat.update',
            'perangkat.delete',
            'peta.view',
            'peta.update',

            'informasi.view',
            'syarat.view',
            'syarat.create',
            'syarat.update',
            'syarat.delete',
            'berita.view',
            'berita.create',
            'berita.update',
            'berita.delete',
            'produk-hukum.view',
            'produk-hukum.create',
            'produk-hukum.update',
            'produk-hukum.delete',

            'lembaga.view',
            'lpmd.view',
            'lpmd.create',
            'lpmd.update',
            'lpmd.delete',
            'posyandu.view',
            'posyandu.create',
            'posyandu.update',
            'posyandu.delete',
            'pkk.view',
            'pkk.create',
            'pkk.update',
            'pkk.delete',
            'bumdes.view',
            'bumdes.create',
            'bumdes.update',
            'bumdes.delete',
            'karang-taruna.view',
            'karang-taruna.create',
            'karang-taruna.update',
            'karang-taruna.delete',
            'koperasi.view',
            'koperasi.create',
            'koperasi.update',
            'koperasi.delete',

            'transparansi.view',
            'apbdes.view',
            'apbdes.create',
            'apbdes.update',
            'apbdes.delete',
            'pembangunan.view',
            'pembangunan.create',
            'pembangunan.update',
            'pembangunan.delete',

            'galeri.view',
            'galeri.create',
            'galeri.update',
            'galeri.delete',

            'kontak.view',
            'kontak.update',

            'aplikasi.view',
            'aplikasi.update',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'role.view',
            'role.create',
            'role.update',
            'role.delete',
            'permission.view',
            'permission.create',
            'permission.update',
            'permission.delete',

            'logactivity.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
