<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\City;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{

    public function __construct()
    {
        //set middleware
        $this->middleware('auth:api');
    }

    public function getDefaultAddress()
    {
        $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('is_default', 1)->first();

        return response()->json([
            'success' => true,
            'message' => 'Address',
            'data'    => $address
        ]);
    }

    public function listAddress()
    {
        $address = Address::where('customer_id', auth()->guard('api')->user()->id)->orderBy('is_default', 'DESC')->get();

        return response()->json([
            'success' => true,
            'message' => 'List Address',
            'data'    => $address
        ]);
    }

    public function setDefault($id)
    {
        $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('is_default', 1)->first();

        if ($address) {
            $address->update([
                'is_default' => 0
            ]);
        }

        $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('id', $id)->first();

        $address->update([
            'is_default' => 1
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Set Default Address Success',
            'data'    => $address
        ]);
    }

    public function addAddress(Request $request)
    {
        if ($request->is_default == 1) {
            $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('is_default', 1)->first();

            if ($address) {
                $address->update([
                    'is_default' => 0
                ]);
            }
            $address = Address::create([
                'customer_id'   => auth()->guard('api')->user()->id,
                'label'          => $request->label,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'province_id'   => $request->province_id,
                'province_name' => $request->province_name,
                'city_id'       => $request->city_id,
                'city_name'     => $request->city_name,
                'subdistrict_id' => $request->subdistrict_id,
                'subdistrict_name' => $request->subdistrict_name,
                'address'       => $request->address,
                'postal_code'   => $request->postal_code,
                'pinpoint'      => $request->pinpoint,
                'notes'         => $request->notes,
                'is_default'    => $request->is_default,
            ]);
        } else {
            $address = Address::create([
                'customer_id'   => auth()->guard('api')->user()->id,
                'label'          => $request->label,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'province_id'   => $request->province_id,
                'province_name' => $request->province_name,
                'city_id'       => $request->city_id,
                'city_name'     => $request->city_name,
                'subdistrict_id' => $request->subdistrict_id,
                'subdistrict_name' => $request->subdistrict_name,
                'address'       => $request->address,
                'postal_code'   => $request->postal_code,
                'pinpoint'      => $request->pinpoint,
                'notes'         => $request->notes,
                'is_default'    => $request->is_default,
            ]);
        }



        return response()->json([
            'success' => true,
            'message' => 'Add Address Success',
            'data'    => $address
        ]);
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('id', $id)->first();

        if ($request->is_default == 1) {
            $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('is_default', 1)->first();

            if ($address) {
                $address->update([
                    'is_default' => 0
                ]);
            }
            $address->update([
                'label'          => $request->label,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'province_id'   => $request->province_id,
                'province_name' => $request->province_name,
                'city_id'       => $request->city_id,
                'city_name'     => $request->city_name,
                'subdistrict_id' => $request->subdistrict_id,
                'subdistrict_name' => $request->subdistrict_name,
                'address'       => $request->address,
                'postal_code'   => $request->postal_code,
                'pinpoint'      => $request->pinpoint,
                'notes'         => $request->notes,
                'is_default'    => $request->is_default,
            ]);
        } else {
            $address->update([
                'label'          => $request->label,
                'name'          => $request->name,
                'phone'         => $request->phone,
                'province_id'   => $request->province_id,
                'province_name' => $request->province_name,
                'city_id'       => $request->city_id,
                'city_name'     => $request->city_name,
                'subdistrict_id' => $request->subdistrict_id,
                'subdistrict_name' => $request->subdistrict_name,
                'address'       => $request->address,
                'postal_code'   => $request->postal_code,
                'pinpoint'      => $request->pinpoint,
                'notes'         => $request->notes,
                'is_default'    => $request->is_default,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Update Address Success',
            'data'    => $address
        ]);
    }

    public function deleteAddress($id)
    {
        $address = Address::where('customer_id', auth()->guard('api')->user()->id)->where('id', $id)->first();

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete Address Success',
            'data'    => $address
        ]);
    }

    public function detailAddress($id)
    {
        $address = DB::table('addresses')->where('id', $id)
        ->where('addresses.customer_id', auth()->guard('api')->user()->id)
        ->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail Address',
            'data'    => $address
        ]);
    }
}
