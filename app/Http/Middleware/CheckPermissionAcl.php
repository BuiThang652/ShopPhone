<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;


class CheckPermissionAcl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission = null): Response
    {
        // Lấy ra các role của user login vào hệ thống        
 
        $listRoleOfUser = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            -> where('users.id',Auth::id())
            ->select('roles.*')
            -> get()->pluck('id')->toArray();

            
        // Lấy các quyền khi user login vào hệ thống
        $listRoleOfUser = DB::table('roles')
            ->join('role_permission', 'roles.id', '=', 'role_permission.role_id')
            ->join('permissions', 'role_permission.permission_id', '=', 'permissions.id')
            -> whereIn('roles.id',$listRoleOfUser)
            ->select('permissions.*')
            -> get()->pluck('id')->unique();
                    
        $checkPermission = DB::table('permissions')->where('name', $permission)->value('id');
        
        if ($listRoleOfUser -> contains($checkPermission)){
            return $next($request);
        }

        if ($checkPermission == 21) {
            return redirect('login');
        } else {
            return redirect('/');
        }
    }
}