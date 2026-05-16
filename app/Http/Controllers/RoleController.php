<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $role = Role::withCount('permissions')->get();
        return response()->view('role-permission.index', ['roles' => $role]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $guard = [
            ['name' => 'admin', 'value' => 'web'],
            ['name' => 'user',  'value' =>  'web'],
            ['name' => 'writer', 'value' => 'web'],
            ['name' => 'editor', 'value' => 'web']
        ];
        return response()->view('role-permission.create', ['guards' => $guard]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string',
            'guard_name' => 'nullable|string'
        ]);

        $user = new Role();
        $user->name = $request->input('name');
        $user->guard_name = 'web';
        $isSaved = $user->save();
        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت الاضافة بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //المنشا عليه هذا الدور guard_name هاتلي كل الصلاحيات التابعة لنفس
        $permissions = Permission::where('guard_name', '=', $role->guard_name)->get();
        $rolePermission = $role->permissions;

        if (count($rolePermission)) {
            foreach ($rolePermission as $userPermission) {
                foreach ($permissions as $permission) {
                    if ($permission->id === $userPermission->id) {
                        $permission->setAttribute('assigned', true);
                    }
                }
            }
        }
        return response()->view('role-permission.role-permission', ['role' => $role, 'permissions' => $permissions]);
    }

    public function updateRolePermission(Request $request)
    {
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'permission_id' => 'required|numeric|exists:permissions,id'
        ]);
        if (! $validator->fails()) {
            $permission = Permission::findOrFail($request->input('permission_id'));
            $role = Role::findOrFail($request->input('role_id'));
            $role->hasPermissionTo($permission)
                ? $role->revokePermissionTo($permission)
                : $role->givePermissionTo($permission);
            return response()->json(['status' => true, 'message' => 'Permssion Updated']);
        } else {
            return response()->json(
                ['status' => false, 'message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $deleted = $role->delete();

        // فك العلاقات
        $role->permissions()->detach();
        $role->users()->detach(); // أضف هذا السطر فقط إذا كنت عامل علاقة users يدوياً

        $deleted = $role->delete();

        return redirect()->back()->with([
            'status' => $deleted,
            'icon' => $deleted ? 'success' : 'error',
            'message' => $deleted ? "تم حذف الدور بنجاح" : "لم يتم الحذف"
        ]);
    }
}
