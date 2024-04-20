<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WirelessRequest extends FormRequest
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
            'ssid' => [
                'required'
            ],
            'master-interface' => [
                'required'
            ],
            'security-profile' => [
                'required'
            ],
            'wps-mode' => [
                'required',
                Rule::in('disabled','push-button','push-button-5s','virtual-push-button-only')
            ],
            'default-authentication' => [
                'nullable',
                Rule::in('true')
            ],
            'default-forwarding' => [
                'nullable',
                Rule::in('true')
            ],
            'hide-ssid' => [
                'nullable',
                Rule::in('true')
            ]
        ];
    }
}
