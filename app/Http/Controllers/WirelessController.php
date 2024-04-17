<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
class WirelessController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireless', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
            $data = json_decode($response->getBody(), true);

            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            return view('wireless.index', ['wireless' => $data]);
        } catch (\Exception $e) {
            return view('wireless.index', ['wireless' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function create(): View {
        return view("wireless.create");
    }

    private function treat_error($errorMessage) 
    {
        $error = null;

        // Search for the detail and error information within the error message
        if (preg_match('/"detail":\s*"([^"]+)"/', $errorMessage, $matches)) {
            $error['detail'] = $matches[1];
        } else {
            $error['detail'] = null;
        }
    
        if (preg_match('/"error":\s*(\d+)/', $errorMessage, $matches)) {
            $error['error'] = (int) $matches[1];
        } else {
            $error['error'] = null;
        }        

        if (preg_match('/"message":\s*"([^"]+)"/', $errorMessage, $matches)) {
            $error['message'] = $matches[1];
        } else {
            $error['message'] = null;
        }

        if ($error['detail'] == null && $error['error'] == null && $error['message'] == null)
            return null;

        return $error;
    }
}
