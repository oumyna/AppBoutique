<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RoleModel;
use Illuminate\Http\Request;
use App\Models\PermissionRoleModel;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    public function list()
    {
        $PermissionRole = PermissionRoleModel::getPermission('User',Auth::user()->role_id);
        if(empty($PermissionRole))
        {
            abort(404);
        }
        $data['PermissionCreate'] = PermissionRoleModel::getPermission('Create User',Auth::user()->role_id);
        $data['PermissionEdit'] = PermissionRoleModel::getPermission('Edit User',Auth::user()->role_id);
        $data['PermissionDestroy'] = PermissionRoleModel::getPermission('Destroy User',Auth::user()->role_id);
        $users = User::with('role')->get();
        return view('panel.user.list', compact('users'));
    }

    public function create()
    {
        $roles = RoleModel::all();
        $users = User::all();
        
        return view('panel.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);


        User::create($request->all());
        
        return redirect()->route('panel.user.list')->with('success', 'Utilisateur créer avec avec succes.');
    }

    public function edit(User $user)
    {
        // Vérifiez que l'utilisateur est bien passé
        //dd($user);
        $roles = RoleModel::all();
        return view('panel.user.edit', compact('user', 'roles'));
    }
    



    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($request->filled('password')) {
            $request->merge(['password' => bcrypt($request->password)]);
        } else {
            $request->merge(['password' => $user->password]);
        }

        $user->update($request->all());
        return redirect()->route('panel.user.list')->with('success', 'Utilisateur modifier avec succes.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('panel.user.list')->with('success', 'Utilisateur supprimer avec succes.');
    }
}
