<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IpAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address' => [
                'required',
                'regex:/^(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\/(?:3[0-2]|[12]?[0-9])$/'
            ],
            'network' => [
                'required',
                'regex:/^(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/'
            ],
            'interface' => [
                'required'
            ],
            'comment' => [
                'nullable',
                'string'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => 'The address field is required.',
            'address.regex' => 'The address field must be a valid IP address in the format 0.0.0.0/0 .',
            'network.required' => 'The network field is required.',
            'network.regex' => 'The network field must be a valid IP address in the format 0.0.0.0 .',
            'interface.required' => 'The interface field is required.',
            'comment.string' => 'The comment field must be a string.',
        ];
    }
}
