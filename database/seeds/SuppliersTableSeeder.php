<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuppliersTableSeeder extends Seeder
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
            'name' => 'suppliers',
            'display_name' => 'Usuarios',
            'icon' => 'icon-people'
        ]);

        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-suppliers',
                'display_name' => 'Leer',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-suppliers',
                'display_name' => 'Crear',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-suppliers',
                'display_name' => 'Actualizar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-suppliers',
                'display_name' => 'Borrar',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ]
        ]);

        // Assign permissions to admin role
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());
    }
}
