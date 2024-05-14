<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
                    'name' => 'NEGOCIOS CRIMO',
                    'email' => 'crimo@gmail.com',
                    'password' => bcrypt('crimo#2024'),
                    'almacene_id' => '1'
                ]);

        $rol = Role::create(['name' => 'ADMINISTRADOR']);
        $permission = Permission::pluck('id', 'id')->all();
        $rol->syncPermissions($permission);
        $user->assignRole('ADMINISTRADOR');
    }
}