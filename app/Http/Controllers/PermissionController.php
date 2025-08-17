<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //This method will show permission page
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('permissions.list', [
            'permissions' => $permissions

        ]);
    }

    //This method will show Create Permission page
    public function create()
    {
        return view('permissions.create');
    }

    //This method will insert a permission in DB
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name|min:3'
        ]);

        if ($validator->passes()) {
            // Insert the permission into the database
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success', 'Permission Added successfully.');
        } else {



            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }

    //This method will show edit permission page
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', ['permission' => $permission]);
    }

    //This method will Update a permission page
    public function update(
        $id,
        Request $request
    ) {

        $permission = Permission::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name|min:3,'.$id.',id'
        ]);

        if ($validator->passes()) {
            // Insert the permission into the database
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission Updated successfully.');
        } else {



            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    //This method will delete a permission in DB
    public function destroy(Request $request) {
        $id = $request->id;
        $permission = Permission::find($id);
        if ($permission == null){
            session()->flash('error', 'Permission not found.');
            return response()->json([
                'status' => 'false',
            ]);
        }

        $permission->delete();
        session()->flash('success', 'Permission deleted successfully.');
        return response()->json([
            'status' => 'true',
        ]);
    }
}
