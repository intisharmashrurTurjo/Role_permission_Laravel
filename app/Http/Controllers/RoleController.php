<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
class RoleController extends Controller
{
    //This Method Will show role page
    public function index()
    {   
        $roles = Role::orderBy('name', 'ASC')->paginate(10);
         return view('roles.list', [
            'roles' => $roles
         ]);
    }
    //This Method Will show create role page
    public function create()
    {
        $permissions = Permission::orderBy('name','ASC')->get();
        return view('roles.create', [
            'permissions' => $permissions
        ]);        
    }

    //This Method will insert a role in DB
      public function store(Request $request){
      $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3'
        ]);

        if ($validator->passes()) {

            // Insert the permission into the database
            $role = Role::create(['name' => $request->name]);
            // Assign permissions to the role
            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }

            return redirect()->route('roles.index')->with('success', 'Role Added successfully.');
        } else {



            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }   
    }
}
