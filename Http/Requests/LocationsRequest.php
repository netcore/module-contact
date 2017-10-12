<?php

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_full'  => 'required',
            'address_short' => 'required',
            'country'       => 'required',
            'city'          => 'required',
            'zip_code'      => 'required',
            'lat'           => 'required|numeric',
            'lng'           => 'required_with:lat|numeric'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
