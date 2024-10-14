<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is incorrect'
            ], 401);
        }


        return response()->json([
            'success' => true,
            'message' => 'Login Success',
            'access_token'   => $token,
        ], 200);
    }

    public function register(Request $request)
    {
        $request->validate([
             'name' => 'required|string|max:255',
            // 'username' => 'required|string|max:255|unique:customers',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:255|unique:customers',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = Customer::create([
            'name' => $request->name ?? null,
            // 'username' => $request->username ?? null,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'access_token' => $token,
        ], 201);
    }

    public function getUser()
    {
        $customers = JWTAuth::parseToken()->authenticate();

        if (
            $customers->name == null ||
            $customers->username == null ||
            $customers->email == null ||
            $customers->phone == null ||
            $customers->birthdate == null ||
            $customers->sex == null
        ) {
            $is_valid = false;
        } else {
            $is_valid = true;
        }

        // get address
        $address = DB::table('addresses')
            ->leftJoin('subdistricts', 'addresses.subdistrict_id', '=', 'subdistricts.subdistrict_id')
            ->leftJoin('cities', 'subdistricts.city_id', '=', 'cities.city_id')
            ->select(
                'cities.name as city_name',
            )
            ->where('addresses.customer_id', $customers->id)
            ->where('addresses.is_default', '1')
            ->groupBy('cities.name')
            ->first();

        if ($address == null) {
            $address = null;
        } else {
            $address = $address->city_name;
        }

        $data = [
            'id' => $customers->id,
            'name' => $customers->name,
            'username' => $customers->username,
            'email' => $customers->email,
            'email_verified_at' => $customers->email_verified_at,
            'avatar' => $customers->avatar,
            'is_valid' => $is_valid,
            'city' => $address,
        ];

        return response()->json([
            'success' => true,
            'message' => 'User Data',
            'data'    => $data
        ], 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Logout Success'
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Refresh Token Success',
            'access_token'   => $refreshToken,
        ], 200);
    }
}
