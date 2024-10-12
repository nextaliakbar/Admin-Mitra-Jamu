<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Customer;
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
                'subdistrict_id' => $request->subdistrict_id,
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
                'subdistrict_id' => $request->subdistrict_id,
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
                'subdistrict_id' => $request->subdistrict_id,
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
                'subdistrict_id' => $request->subdistrict_id,
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
        $address = DB::table('addresses')
            ->join('subdistricts', 'subdistricts.subdistrict_id', '=', 'addresses.subdistrict_id')
            ->join('cities', 'cities.city_id', '=', 'subdistricts.city_id')
            ->join('provinces', 'provinces.province_id', '=', 'cities.province_id')
            ->select(
                'addresses.*',
                'subdistricts.name as subdistrict_name',
                'subdistricts.subdistrict_id as subdistrict_id',
                'cities.name as city_name',
                'cities.city_id as city_id',
                'provinces.name as province_name',
                'provinces.province_id as province_id',
            )
            ->where('addresses.id', $id)
            ->where('addresses.customer_id', auth()->guard('api')->user()->id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Detail Address',
            'data'    => $address
        ]);
    }
}
