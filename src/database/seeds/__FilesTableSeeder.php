<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FilesTableSeeder extends Seeder
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
            'name' => 'files',
            'display_name' => 'Archivos de Importacion',
            'icon' => 'icon-upload',
            'active' => false
        ]);
 
        // Permissions
        DB::table('permissions')->insert([
            [
                'name' => 'read-files',
                'display_name' => 'Leer Archivos',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'update-files',
                'display_name' => 'Actualizar Archivos',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'delete-files',
                'display_name' => 'Borrar Archivos',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
            [
                'name' => 'create-files',
                'display_name' => 'Crear Archivos',
                'guard_name' => 'web',
                'module_id' => $moduleId
            ],
        ]);

        // Assign permissions to admin role
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        // Assign permissions to user role
        //$user = Role::findByName('user');
        //$user->givePermissionTo('read-profile', 'update-profile', 'read-profile-password', 'update-profile-password');

    }
}
