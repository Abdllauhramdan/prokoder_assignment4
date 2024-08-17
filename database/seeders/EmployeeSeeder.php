<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
    
        $role = Role::create([
            'name' => 'Employee',
            'guard_name' => 'api',
        ]);
    

        $employeePermissions = [
            'create articles',
            'edit articles',
            'delete articles',
            'view articles',
            'create categories',
            'edit categories',
            'delete categories',
            'view categories',
        ];

        foreach ($employeePermissions as $permissionName) {
            $permission = Permission::where('name', $permissionName)->where('guard_name', 'api')->first();
            if ($permission) {
                $role->givePermissionTo($permission);
            }
        }

    
        $employeeUser  = User::create([
            'email' => 'employee@example.com',
            'name' => 'Employee User',
            'password' => Hash::make('password123'),
            
        ]);

        $user->assignRole('Employee');

        
        





        
       

       
    }
}
