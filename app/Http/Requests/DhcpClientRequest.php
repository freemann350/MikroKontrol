<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DhcpClientRequest extends FormRequest
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
            'interface'=> [
                'required'
            ],
            'add-default-route'=> [
                'required',
                Rule::in('no','special-classless', 'yes')
            ],
            'use-peer-dns'=> [
                'nullable',
                Rule::in('true')
            ],
            'use-peer-ntp'=> [
                'nullable',
                Rule::in('true')
            ]
        ];
    }
    public function messages()
    {
        return [
            'interface.required' => 'The interface field is required.',
            'add-default-route.required' => 'The add-default-route field is required.',
            'add-default-route.in' => 'The add-default-route field must be one of: no, special-classless, yes.',
            'use-peer-dns.in' => 'The use-peer-dns field must be true.',
            'use-peer-ntp.in' => 'The use-peer-ntp field must be true.'
        ];
    }
}
