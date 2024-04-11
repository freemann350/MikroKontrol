<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class InterfaceExists implements Rule
{
    public function passes($attribute, $value)
    {
        // Make an API request to the interfaces endpoint to check if the interface exists
        $response = Http::get('http://your-api-endpoint/interfaces');

        // Check if the response contains the interface
        return $response->json()['data'] ?? null;
    }

    public function message()
    {
        return 'The selected interface does not exist.';
    }
}
