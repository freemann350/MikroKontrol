<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaticRouteRequest extends FormRequest
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
            'dst-address'=> [
                'required',
                'regex:/^(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\/(?:3[0-2]|[12]?[0-9])$/'
            ],
            'gateway'=> [
                'required',
                'string'
            ],
            'check-gateway' => [
                'required',
                Rule::in(['ping', 'arp', 'none']),
            ],
            'suppress-hw-offload' => [
                'nullable',
                Rule::in(['true'])
            ],
            'distance'=> [
                'nullable',
                'between:0,255'
            ],
            'scope'=> [
                'nullable',
                'between:0,255'
            ],
            'target-scope'=> [
                'nullable',
                'between:0,255'
            ]
        ];
    }
    public function messages()
{
    return [
        'dst-address.required' => 'The destination address is required.',
        'dst-address.regex' => 'The destination address must be in the format xxx.xxx.xxx.xxx/xx.',
        'gateway.required' => 'The gateway address is required.',
        'check-gateway.required' => 'The check-gateway field is required.',
        'check-gateway.in' => 'The check-gateway field must be one of: ping, arp, none.',
        'suppress-hw-offload.in' => 'The suppress-hw-offload field must be true.',
        'distance.between' => 'The distance must be between 0 and 255.',
        'scope.between' => 'The scope must be between 0 and 255.',
        'target-scope.between' => 'The target-scope must be between 0 and 255.',
    ];
}
}

