<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create([
            'name' => 'Admin',
            'guard_name' => 'api',
        ]);

        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);

        
        $user = User::create([
            'email' => 'admin@example.com',
            'name' => 'Admin User',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('Admin');
    }
}
