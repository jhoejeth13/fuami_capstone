<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create permissions if they don't exist
        Permission::firstOrCreate(['name' => 'view-user', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create-user', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit-user', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete-user', 'guard_name' => 'web']);
    
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editorRole = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
    
        // Assign permissions to roles
        $adminRole->givePermissionTo(['view-user', 'create-user', 'edit-user', 'delete-user']);
        $editorRole->givePermissionTo(['view-user', 'edit-user']);
        $userRole->givePermissionTo(['view-user']);
    }
}