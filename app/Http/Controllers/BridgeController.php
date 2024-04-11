<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\BridgeRequest;
class BridgeController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();
            $response = $client->get('http://192.168.88.1/rest/interface/bridge', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view('bridges.index', ['bridges' => $data]);
            
        } catch (\Exception $e) {
            return view('bridges.index', ['bridges' => null, 'conn_error' => $e->getMessage()]);
        }
    }
    
    public function create(): View 
    {
        return view("bridges.create");
    }

    public function store(BridgeRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        if ($formData["admin-mac"] != null )
            $formData["auto-mac"] = "false";

        if (is_null($formData["ageing-time"]))
            unset($formData["ageing-time"]);

        if (is_null($formData["mtu"]))
            unset($formData["mtu"]);

        if (is_null($formData["admin-mac"]))
            unset($formData["admin-mac"]);

        if ($formData["dhcp-snooping"])
        $formData["dhcp-snooping"] = "true";

        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/interface/bridge', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('Bridges.index');
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
}
