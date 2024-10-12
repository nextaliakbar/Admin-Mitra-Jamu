<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Role\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('pages.UserManagement.role.index', compact('roles', 'permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $roles = Role::create([
            'name' => $request->name,
        ]);
        $roles->syncPermissions($request->permissions);

        if (!$roles) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Roles created successfully');
    }

    public function edit(Role $role)
    {
        $permissions = $role->permissions;
        return response()->json([
            'status' => true,
            'data' => $role,
            'permissions' => $permissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role->update([
            'name' => $request->name,
        ]);
        $role->syncPermissions($request->permissions);

        if (!$role) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Role updated successfully');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        if (!$role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
