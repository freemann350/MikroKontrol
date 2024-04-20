<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BridgeRequest extends FormRequest
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
            'ageing-time' => [
                'nullable', 
            ],
            'mtu' => [
                'nullable', 
                'string'
            ],
            'admin-mac' => [
                'nullable', 
                'string',
                'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$/'
            ],
            'dhcp-snooping' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'ageing.date_format' => 'The ageing field must be in valid format (e.g., 21:58:39).',
            'mtu.integer' => 'The mtu field must be an integer.',
            'mac.string' => 'The mac field must be a string.',
            'mac.regex' => 'The MAC address field must be in a valid format (e.g., 12:34:56:78:90:AB).',
            'snooping.boolean' => 'The snooping field must be a boolean value.',
        ];
    }
}
