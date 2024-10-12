<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\Permission\StorePermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return view('pages.UserManagement.permission.index', compact('permissions', 'permissions'));
    }

    public function store(StorePermissionRequest $request)
    {
        $permissions = Permission::create([
            'name' => $request->name,
        ]);

        if (!$permissions) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Permission created successfully');
    }

    public function edit(Permission $permission)
    {
        return response()->json([
            'status' => true,
            'data' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $permission->update([
            'name' => $request->name,
        ]);

        if (!$permission) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Permission updated successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        if (!$permission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Permission deleted successfully',
            'title' => 'Success.',
        ]);
    }
}
