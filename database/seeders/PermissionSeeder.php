<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create articles',
            'edit articles',
            'delete articles',
            'view articles',
            'create categories',
            'edit categories',
            'delete categories',
            'view categories',
            'delete subscribtions',
            'update subscribtions',
            'view subscribtions',
            'delete members',
            'update members',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['guard_name' => 'api', 'name' => $permission]);
        }
    }
}
