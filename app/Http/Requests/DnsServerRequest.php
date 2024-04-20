<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DnsServerRequest extends FormRequest
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
            'servers' => [
                'nullable'
            ],
            'use-doh-server' => [
                'nullable'
            ],
            'doh-max-concurrent-queries'=> [
                'required',
                'integer'
            ],
            'doh-max-server-connections'=> [
                'required',
                'integer'
            ],
            'doh-timeout'=> [
                'required'
            ],
            'max-udp-packet-size'=> [
                'required',
                'integer',
                'between:50,65507'
            ],
            'query-server-timeout'=> [
                'required'
            ],
            'query-total-timeout'=> [
                'required'            ],
            'allow-remote-requests'=> [
                'nullable',
                Rule::in('true')
            ],
            'address-list-extra-time'=> [
                'required'
            ],
            'cache-size'=> [
                'required',
                'integer',
                'between:64,4294967295'
            ],
            'cache-max-ttl'=> [
                'required'
            ],
        ];
    }
}
