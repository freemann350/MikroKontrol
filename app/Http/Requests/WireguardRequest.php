<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WireguardRequest extends FormRequest
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
            'mtu' => [
                'nullable',
                'integer'
            ],
            'listen-port' => [
                'required',
                'integer',
                'between:1024,65535'
            ],

        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The Name field is required.',
            'name.string' => 'The Name field must be a string.',
            'mtu.integer' => 'The MTU field must be an integer.',
            'listen-port.integer' => 'The Port field must be an integer.',
            'listen-port.between' => 'The Port field must be an integer between 1024 and 65535.',
        ];
    }
}
