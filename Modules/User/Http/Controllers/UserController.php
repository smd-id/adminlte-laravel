<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;
use Modules\User\Entities\Agama;
use Modules\User\Entities\Gender;
use Modules\User\Entities\Pekerjaan;
use Modules\User\Entities\Perkawinan;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin', ['only' => ['index', 'store', 'edit']]);
    }
    public function index()
    {
        // $users = User::latest()->with(['roles', 'desa', 'kecamatan', 'kabupaten', 'provinsi'])->get();
        // $roles = Role::pluck('name', 'name')->all();
        return view('user::user_index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role' => 'required',
            'email' => 'unique:users,email,' . $request->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $request->id,
        ]);

        $user = User::updateOrCreate(['id' => $request->id], $request->except(['_token', 'id', 'password', 'role']));
        DB::table('model_has_roles')->where('model_id', $request->id)->delete();
        $user->assignRole($request->role);
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('admin.user.index');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $roles = $user->roles->pluck('name');
        return response()->json(['user' => $user, 'role' => $roles]);
    }
    public function profile()
    {
        $user = Auth::user();
        $roles = Role::pluck('name', 'name')->all();
        $genders = Gender::pluck('name', 'name')->all();
        $agamas = Agama::pluck('name', 'name')->all();
        $perkawinans = Perkawinan::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $provinces = Province::pluck('name', 'id');
        $cities = City::where('province_code', $user->province_id)->pluck('name', 'id')->all();
        $districts = District::where('city_code', $user->city_id)->pluck('name', 'id')->all();
        $villages = Village::where('district_code', $user->district_id)->pluck('name', 'id')->all();
        return view('user::profile', compact(
            'user',
            'roles',
            'userRole',
            'genders',
            'agamas',
            'perkawinans',
            'provinces',
            'cities',
            'districts',
            'villages',
        ));
    }
    public function profile_update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email,' . $user->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $user->id,
        ]);
        $user->update($request->all());
        Alert::success('Success', 'Data Telah Disimpan');
        return redirect()->route('profil');
    }
}
