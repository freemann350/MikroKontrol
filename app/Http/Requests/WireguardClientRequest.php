<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WireguardClientRequest extends FormRequest
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
            'name' => [
                'required',
                'string'
            ],
            'interface' => [
                'required'
            ],
            'public-key' => [
                'required'
            ],           
            'private-key' => [
                'nullable'
            ],  
            'auto-pk' => [
                'nullable',
                Rule::in('true')
            ],
            'endpoint-address' => [
                'nullable'
            ],
            'endpoint-port' => [
                'nullable',
                'integer'
            ],
            'allowed-address' => [
                'required',
                'regex:/^(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\/(?:3[0-2]|[12]?[0-9])$/'
            ],
            'preshared-key' => [
                'nullable'
            ],
            'auto-psk' => [
                'nullable',
                Rule::in('true')
            ],
            'persistent-keepalive' => [
                'nullable'
            ],
        ];
    }
    public function messages(): array
    {
        return [
        ];
    }
}
