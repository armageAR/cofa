<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Module
        $moduleId = DB::table('modules')->insertGetId([
            'name' => 'roles',
            'display_name' => 'Roles',
            'icon' => 'icon-key'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-roles',
                'display_name' => 'Leer',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-roles',
                'display_name' => 'Crear',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-roles',
                'display_name' => 'Actualizar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-roles',
                'display_name' => 'Borrar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Create default roles
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);
        $user = Role::create([
            'name' => 'user',
            'display_name' => 'Usuario'
        ]);

        // Assign permissions to admin role
        $admin->givePermissionTo(Permission::all());
    }
}
