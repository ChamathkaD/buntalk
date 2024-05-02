<?php

namespace Cyntrek\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:50|min:2',
            'last_name'  => 'required|string|max:50|min:2',
            'email'      => 'required|string|email|max:100',
            'phone'      => 'nullable|string|max:50',
            'message'    => 'required|string|min:10|max:500',
        ];
    }
}
