<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\Roles\RolesStoreRequest;
use App\Http\Requests\Admin\Roles\RolesUpdateRequest;
use App\Traits\AuthorizeCheck;
class RolesAndPermissionsController extends Controller
{
  use AuthorizeCheck;

  public function index(){
    $this->authorizeCheck('country view');
    $role = Role::all();
    return response(['success'=>true,'data'=>$role],200);

  }

  public function store(RolesStoreRequest $request)
  {
    $data = $request->validated();
    $role = Role::create(['name'=>$request->role, 'guard_name'=>'web'])->givePermissionTo($request->permissions);
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    return response(['success'=>true,'data'=>$role],200);
  }
  //show with permissions

  public function show($lang , $id)
  {
    $this->authorizeCheck('country view');
    $role=Role::find($id);
    $role->permissions;
    // $permissions=Permission::all();
    return response(['success'=>true,'data'=>$role],200);

  }

  //edit

  public function update( $lang,RolesUpdateRequest $request, $id)
{
    $data = $request->validated();

    $role = Role::find($id);

    if ($role) {
        // Revoke existing permissions
        $role->revokePermissionTo($role->permissions);

        // Give permissions from the request data
        $role->givePermissionTo($data['permissions']);

        // Update the role name
        $role->update(['name' => $data['role']]);

        // Clear the cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return response(['success' => true, 'data' => $role], 201);
    }

    return response(['success' => false, 'data' => 'not found'], 404);
}

  // delete role

  public function destroy($lang,$id)
  {
    $this->authorizeCheck('country view');
    $role = Role::find($id);
   
    
    
      if($role){
        $permissions = $role->permissions??[];
        $role->revokePermissionTo($permissions);
        $role->delete();
    
        return response(['success'=>true,'data'=>$role],200);
      }
  
           return response(['success'=>false,'data'=>'not found'],404);
   

  }
}
