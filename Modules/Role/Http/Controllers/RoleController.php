<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin');
    }
    public function index()
    {
        $roles = Role::with(['permissions'])->latest()->get();
        $permissions = Permission::get();
        return view('role::role_index', compact(['roles', 'permissions']))->with(['i' => 0, 'j' => 0]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $request->id,
        ]);

        $role = Role::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        $role->syncPermissions($request->permission);

        Alert::success('Success Info', 'Success Message');
        return redirect()->route('admin.role.index');
    }
    public function edit($id)
    {
        $role = Role::find($id);
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id')
            ->all();
        return response()->json(['role' => $role, 'rolePermissions' => $rolePermissions]);
    }
    public function destroy($id)
    {
        Role::find($id)->delete();
        return redirect()->route('admin.role.index');
    }
}
