<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Permission::class, 'permission');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $permissions = Permission::all();
        return response()->view('role-permission.permissions', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
        return response()->view('role-permission.editPermission', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $request->validate([
            'name' => 'required|string',
        ]);
        $permission->name = $request->input('name');
        $isSaved = $permission->save();
        return redirect()->back()->with([
            'status' => true,
            'icon' => $isSaved ? 'success' : 'error',
            'message' =>  $isSaved ? "تمت التعديل بنجاح" : "لم يتم التعديل يرجى التحقق من البيانات"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
        $deletedCount = $permission->delete();
        return redirect()->back()->with([
            'status' => true,
            'icon' => $deletedCount ? 'success' : 'error',
            'message' =>  $deletedCount ? "تم الحذف بنجاح" : "لم يتم الاضافة يرجى التحقق من البيانات"
        ]);
    }
}
