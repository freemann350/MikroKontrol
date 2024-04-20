<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DhcpServerRequest extends FormRequest
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
            'name'=> [
                'required',
                'string'
            ],
            'interface'=> [
                'required',
                'string'
            ],
            'relay'=> [
                'nullable',
                'regex:/^(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/'
            ],
            'lease-time'=> [
                'nullable'
            ],
            'address-pool'=> [
                'required',
                Rule::in('static-only','default-dhcp')
            ],
            'authoritative'=> [
                'required',
                Rule::in('yes','no','after-2sec-delay','after-10sec-delay')
            ],
            'comment'=> [
                'nullable',
                'string'
            ],
            'always-broadcast'=> [
                'nullable',
                Rule::in('true')
            ],
            'add-arp'=> [
                'nullable',
                Rule::in('true')
            ],
            'use-framed-as-classless'=> [
                'nullable',
                Rule::in('true')
            ],
            'conflict-detection'=> [
                'nullable',
                Rule::in('true')
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'interface.required' => 'The interface field is required.',
            'interface.string' => 'The interface field must be a string.',
            'relay.regex' => 'The relay field must be a valid IP address in the format 0.0.0.0 .',
            'lease-time.date_format' => 'The lease-time field must be in the format H:i:s.',
            'address-pool.required' => 'The address-pool field is required.',
            'address-pool.in' => 'The address-pool field must be one of: static-only, default-dhcp.',
            'alway-broadcast.in' => 'The alway-broadcast field must be true.',
            'add-arp.in' => 'The add-arp field must be true.',
            'use-framed-as-classless.in' => 'The use-framed-as-classless field must be true.',
            'conflict-detection.in' => 'The conflict-detection field must be true.'
        ];
    }
}
