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
        
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/interface/wireguard', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('Wireguard.index');
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
}
