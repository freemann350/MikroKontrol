<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SecurityProfileRequest extends FormRequest
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
            'mode'=> [
                'required',
                Rule::in('none','dynamic-keys')
            ],
            'wpa2-psk'=> [
                'nullable',
                Rule::in('true')
            ],
            'wpa2-eap'=> [
                'nullable',
                Rule::in('true')
            ],
            'uc-aes-ccm'=> [
                'nullable',
                Rule::in('true')
            ],
            'uc-tkip'=> [
                'nullable',
                Rule::in('true')
            ],
            'gc-aes-ccm'=> [
                'nullable',
                Rule::in('true')
            ],
            'gc-tkip'=> [
                'nullable',
                Rule::in('true')
            ],
            'wpa2-pre-shared-key' => [
                'nullable',
                'string',
                'min:8',
                'required_if:wpa2-psk,true',
            ],
            'supplicant-identity'=> [
                'nullable',
                'required_if:wpa2-eap,true',
            ],
            'group-key-update'=> [
                'nullable',
                'date_format:H:i:s'
            ],
            'management-protection'=> [
                'required',
                Rule::in('disabled','required', 'allowed')
            ],
            'management-protection-key'=> [
                'nullable',
                Rule::requiredIf(function () {
                    return request()->input('management-protection') === 'allowed'
                        || request()->input('management-protection') === 'required';
                })
            ],
            'disable-pmkid'=> [
                'nullable',
                Rule::in('true')
            ]
        ];
    }
}
