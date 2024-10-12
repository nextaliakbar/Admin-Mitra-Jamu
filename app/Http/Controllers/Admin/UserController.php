<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backoffice\User\StoreUserRequest;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();

        // dd($users)
        return view('pages.UserManagement.user.index', compact('users', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($request->role);

        if (!$user) {
            return responseToast('error', 'Something went wrong', null, 500);
        }

        return responseToast('success', 'Berhasil menambahkan pengguna baru');
    }

    public function edit(User $user)
    {
        $userRole = $user->getRoleNames()->first();
        return response()->json([
            'status' => true,
            'data' => $user,
            'userRole' => $userRole,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->syncRoles($request->role);

        if (!$user) {
            return responseToast('error', 'Something went wrong', null, 500);
        }
        return responseToast('success', 'Berhasil mengubah data pengguna');
    }

    public function destroy(User $user)
    {
        $user->delete();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
                'title' => 'Error!'
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus pengguna',
            'title' => 'Success.',
        ]);
    }

    public function profile()
    {
        return view('pages.users.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'password' => 'nullable|confirmed',
        ]);

        if ($request->password == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tolong masukkan password anda untuk mengubah data profil',
                'title' => 'Error!'
            ]);
        }

        // if password not match with current password then return error
        if (!Hash::check($request->password, auth()->user()->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password yang anda masukkan tidak sesuai',
                'title' => 'Error!'
            ]);
        }

        if ($request->folder != null) {
            $folder = $request->folder;
            $filename = $request->filename;

            File::move(storage_path('app/public/temporary/' . $folder . '/' . $filename), storage_path('app/public/users/' . $filename));
            $mime = File::mimeType(storage_path('app/public/users/' . $filename));

            $temporaryFile = TemporaryFile::where('folder', $folder)->first();
            $temporaryFile->delete();

            if (TemporaryFile::where('folder', $folder)->count() == 0) {
                File::deleteDirectory(storage_path('app/public/temporary/' . $folder));
            }

            $media_url = url('storage/users/' . $filename);
        }


        $user = User::find(auth()->id());

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'avatar' => $request->folder != null ? $media_url : $user->avatar,
        ]);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kesalahan saat mengubah data profil',
                'title' => 'Error!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data profil berhasil diubah',
            'title' => 'Success.',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|min:8',
        ]);

        $user = User::find(auth()->id());

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password yang anda masukkan tidak sesuai',
                'title' => 'Error!'
            ]);
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kesalahan saat mengubah password',
                'title' => 'Error!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil diubah',
            'title' => 'Success.',
        ]);
    }
}
