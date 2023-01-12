<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RoleManagementController extends Controller
{
    use HasRoles;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }
    public function RoleManagement(Request $request)
    {

        // $_admin1 = Role::create(['guard_name' => 'api', 'name' => $request->role_name]);
        // $_admin2 = Role::create(['guard_name' => 'admin', 'name' => $request->role_name]);

        $s_us = User::find($request->user_id);
        $s_us->syncPermissions('perpustakaan');

        // auth()->user()->roles->pluck('name')[0]
        return response()->json($s_us->roles);
    }
}
