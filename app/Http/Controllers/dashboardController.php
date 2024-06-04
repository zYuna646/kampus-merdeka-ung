<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function admin()
    {
        $role_op = Role::where("slug","operator")->first();
        $operator = User::where('role_id', $role_op->id)->count();
        $data = [
            'pengelola' => $operator
        ];
        return view('admin.superadmin.dashboard_superadmin')->with('data',$data);
    }
}
