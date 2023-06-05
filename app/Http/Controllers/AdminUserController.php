<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;


class AdminUserController extends Controller
{
    public function show() {

        $users = DB::table('users')->get();

        return view('admin.user.show', ['users'=>$users]);
    }

    public function create() {

        $users = DB::table('users')->get();
        $roles = DB::table('roles')->get();

        return view('admin.user.create', ['users'=>$users, 'roles'=>$roles]);
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();

            $user = DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user_id = DB::table('users')
            ->where('name', '=' , $request->name)
            ->where('email', '=', $request->email)
            ->get()->last() ;            
            
            $roles = $request->roles;

            foreach ($roles as $roleId) {
                DB::table('role_user')->insert([
                    'user_id' => $user_id->id,
                    'role_id' => $roleId
                ]);
            }
            
            DB::commit();

            return redirect()->route('admin.user.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }

    public function edit(Request $request, $id) {
        $users = DB::table('users')->where('id', $id)->get();
        $roles = DB::table('roles')->get();
        $user = $users->last();

        $listRoleOfUser = DB::table('role_user')->where('user_id', $id)->pluck('role_id');

        return view('admin.user.edit', ['users'=>$users,'user'=>$user ,'roles'=>$roles, 'id'=>$id, 'listRoleOfUser'=>$listRoleOfUser]);
    }

    public function update(Request $request, $id) {
        try {
            DB::beginTransaction();

            $userCreate = DB::table('users')->where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            DB::table('role_user')->where('user_id', $id)->delete();
            $roles = $request->roles;
                
            foreach ($roles as $roleId) {
                DB::table('role_user')->insert([
                    'user_id' => $id,
                    'role_id' => $roleId
                ]);
            };

            DB::commit();

            return redirect()->route('admin.user.show');
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
    
    public function delete($id) {
        try {
            DB::beginTransaction();

            $order_id = DB::table('orders')
                ->select('id')
                ->where('user_id', $id);
        
    
            $orderItems = DB::table('order_items')
                ->whereIn('order_id', $order_id)->delete();
    
            DB::table('orders')->where('user_id', $id)->delete();
    
            DB::table('role_user')->where('user_id', $id)->delete();
    
            DB::table('users')->where('id', $id)->delete();
    
            DB::commit();
    
            return redirect()->route('admin.user.show');
        } catch (Exception $exception) {
            DB::rollBack();
            // Xử lý lỗi
        }
    }
    
}