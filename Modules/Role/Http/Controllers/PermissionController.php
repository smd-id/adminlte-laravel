<?php

namespace Modules\Role\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $request->id,
        ]);
        Permission::updateOrCreate(['id' => $request->id], ['name' => $request->name]);
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('admin.role.index');
    }
    public function edit($id)
    {
        $permission = Permission::find($id);
        return response()->json(['permission' => $permission]);
    }
    public function destroy($id)
    {
        Permission::find($id)->delete();
        return redirect()->route('admin.role.index');
    }
}
