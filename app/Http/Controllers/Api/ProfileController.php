<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $customer = auth()->guard('api')->user();

        return response()->json([
            'success' => true,
            'data' => $customer
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        $customer = auth()->guard('api')->user();

        // validate
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:customers,username,' . $customer->id,
            'birthdate' => 'required',
            'sex' => 'required',
            'phone' => 'required|unique:customers,phone,' . $customer->id,
            'email' => 'required|email|unique:customers,email,' . $customer->id,
        ]);

        $dataCustomer = [
            'name' => $request->name,
            'username' => $request->username,
            'birthdate' => $request->birthdate,
            'sex' => $request->sex,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        $update = Customer::where('id', $customer->id)->update($dataCustomer);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'Profil gagal diperbarui'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $dataCustomer
        ], 200);
    }

    public function updatePhoto(Request $request)
    {
        $customer = auth()->guard('api')->user();

        $request->validate([
            'avatar' => 'required'
        ]);

        $image = $request->avatar;
        $base64_str = substr($image, strpos($image, ",") + 1);
        $image = base64_decode($base64_str);
        $folder = $customer->username;
        $path = 'public/customers/' . $folder;
        $urlImage = $folder . '/' . time() . '.png';
        Storage::put($path . '/' . time() . '.png', $image);

        $urlImage = url('storage/customers/' . $urlImage);

        $oldImage = $customer->avatar;
        $oldImage = explode('/', $oldImage);
        $oldImage = end($oldImage);
        Storage::delete($path . '/' . $oldImage);

        $update = Customer::where('id', $customer->id)->update([
            'avatar' => $urlImage
        ]);

        if (!$update) {
            return response()->json([
                'success' => false,
                'message' => 'Avatar gagal diperbarui'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Avatar berhasil diperbarui'
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $customer = auth()->guard('api')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ]);

        if (password_verify($request->current_password, $customer->password)) {
            Customer::where('id', $customer->id)->update([
                'password' => bcrypt($request->new_password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diperbarui'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Password lama salah'
        ], 401);
    }

    public function checkUsername(Request $request)
    {
        $customer = auth()->guard('api')->user();

        $request->validate([
            'username' => 'required'
        ]);

        $username = $request->username;

        $check = Customer::where('username', $username)->where('id', '!=', $customer->id)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Username sudah digunakan'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Username tersedia'
        ], 200);
    }

    public function checkEmail(Request $request)
    {
        $customer = auth()->guard('api')->user();

        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->email;

        $check = Customer::where('email', $email)->where('id', '!=', $customer->id)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah digunakan'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email tersedia'
        ], 200);
    }

    public function checkPhone(Request $request)
    {
        $customer = auth()->guard('api')->user();

        $request->validate([
            'phone' => 'required'
        ]);

        $phone = $request->phone;

        $check = Customer::where('phone', $phone)->where('id', '!=', $customer->id)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon sudah digunakan'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Nomor telepon tersedia'
        ], 200);
    }
}
