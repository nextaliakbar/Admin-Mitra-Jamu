<?php

namespace App\Http\Requests\Backoffice\Asset;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'date' => 'required',
            'unit' => 'required',
            'type' => 'required',
            'useful_life' => 'required',
            'assets_price' => 'required',
            'monthly_depreciation' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'date.required' => 'Date is required',
            'unit.required' => 'Unit is required',
            'type.required' => 'Type is required',
            'useful_life.required' => 'Useful Life is required',
            'assets_price.required' => 'Assets Price is required',
            'monthly_depreciation.required' => 'Monthly Depreciation is required',

        ];
    }
}
