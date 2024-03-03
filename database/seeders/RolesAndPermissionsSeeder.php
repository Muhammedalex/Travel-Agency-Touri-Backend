<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $arrOfPermissionNames = [
            'country create' , 'country view' , 'country edit' ,'country delete',
            'admin only' , 'user view'
        ];
        $permissions = collect($arrOfPermissionNames)->map(function($permisson){
            return ['name'=>$permisson , 'guard_name'=>'web'];
        });

        Permission::insert($permissions->toArray());

        $role = Role::create(['name'=>'super admin'])
        ->givePermissionTo($arrOfPermissionNames);
    }
}
