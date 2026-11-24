<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tarif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $permissions = [
            'manage-user',
            'manage-tarif',
            'manage-area',
            'manage-kendaraan',
            'log',
            'transaksi',
            'rekap',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);

        $adminRole->syncPermissions(Permission::all());

        $petugasRole->syncPermissions([
            'manage-kendaraan',
            'transaksi'
        ]);

        $ownerRole->syncPermissions([
            'rekap',
            'log'
        ]);

        $admin = User::firstOrCreate([
            'nama_lengkap' => 'Diki Muhamad A',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);

        $admin->assignRole($adminRole);

        $petugas = User::firstOrCreate([
            'nama_lengkap' => 'Petugas',
            'username' => 'petugas',
            'password' => bcrypt('petugas'),
            'role' => 'petugas'
        ]);

        $petugas->assignRole($petugasRole);

        $owner = User::firstOrCreate([
            'nama_lengkap' => 'Diki Muhamad A',
            'username' => 'owner',
            'password' => bcrypt('owner'),
            'role' => 'owner'
        ]);

        $owner->assignRole($ownerRole);

        Tarif::firstOrCreate([
            'jenis_kendaraan' => 'motor',
            'tarif_perjam' => '0'
        ]);

        Tarif::firstOrCreate([
            'jenis_kendaraan' => 'mobil',
            'tarif_perjam' => '0'
        ]);

        Tarif::firstOrCreate([
            'jenis_kendaraan' => 'lainnya',
            'tarif_perjam' => '0'
        ]);
    }
}
