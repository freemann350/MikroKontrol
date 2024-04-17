<?php

namespace App\Http\Controllers;

use App\Http\Requests\WireguardRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WireguardController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();
            $response = $client->get('http://192.168.88.1/rest/interface/wireguard', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view('wireguard.index', ['wg' => $data]);
            
        } catch (\Exception $e) {
            return view('wireguard.index', ['wg' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function create(): View 
    {
        return view('wireguard.create');
    }

    public function store(WireguardRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        
        if ($formData['mtu'] == null)
            unset($formData['mtu']);
        
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/interface/wireguard', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('Wireguard.index')->with('success-msg', "A Wireguard Interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
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
