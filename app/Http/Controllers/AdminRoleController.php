<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Role;

class AdminRoleController extends Controller
{
    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function show() {
        $users = DB::table('users')->get();
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->get();

        return view('admin.role.show',['users'=>$users, 'roles'=>$roles, 'permissions'=> $permissions]);
    }

    public function create() {
        $users = DB::table('users')->get();
        $roles = DB::table('roles')->get();
        $permissions = DB::table('permissions')->get();

        return view('admin.role.create', ['users'=>$users, 'roles'=>$roles, 'permissions'=> $permissions]);
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $roleCreate = DB::table('roles')->insert([
                'name' => $request->name,
                'display_name' => $request->display_name
            ]);
    
            $role_id = DB::table('roles')
                    ->where('name', '=' , $request->name)
                    ->where('display_name', '=', $request->display_name)
                    ->get()->last() ;
            
            $permissions = $request->permissions;
    
            foreach ($permissions as $permissionId) {
                DB::table('role_permission')->insert([
                    'role_id' => $role_id->id,
                    'permission_id' => $permissionId
                ]);
            }

            DB::commit();

            return redirect()->route('admin.role.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function edit(Request $request, $id) {
        $users = DB::table('users')->get();
        $roles = DB::table('roles')->where('id', $id)->first();
        $permissions = DB::table('permissions')->get();
        $role_permission = DB::table('role_permission')->get();
        $getAllPermissionOfRole = DB::table('role_permission')->where('role_id',$id)->pluck('permission_id');

        return view('admin.role.edit', ['users'=>$users, 'roles'=>$roles, 'permissions'=> $permissions,'id'=>$id, 'getAllPermissionOfRole'=>$getAllPermissionOfRole]);
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();

            $roleCreate = DB::table('roles')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'display_name' => $request->display_name
            ]);

            DB::table('role_permission')->where('role_id', $id)->delete();

            $permissions = $request->permissions;

            // dd($permissions);
    
            foreach ($permissions as $permissionId) {
                DB::table('role_permission')
                ->insert([
                    'role_id' => $id,
                    'permission_id' => $permissionId
                ]);
            }

            DB::commit();

            return redirect()->route('admin.role.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function delete ($id) {
        try {
            DB::beginTransaction();
            
            $role_permission = DB::table('role_permission')->where('role_id', $id)->get();
            foreach ($role_permission as $role_id) {
                DB::table('role_permission')->where('id', $role_id->id)->delete();
            }

            DB::table('roles')->where('id', $id)->delete();

        
            DB::commit();

            return redirect()->route('admin.role.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
}