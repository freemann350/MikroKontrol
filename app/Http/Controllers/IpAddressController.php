<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\IpAddressRequest;
use GuzzleHttp\Exception\RequestException;

class IpAddressController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/ip/address', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            return view('ip_addresses.index', ['addresses' => $data]);
        } catch (\Exception $e) {
            return view('ip_addresses.index', ['addresses' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function create(): View {
        try {
            
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view("ip_addresses.create",['interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('ip_addresses.create', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }
    public function store(IpAddressRequest $request): RedirectResponse 
    {
        $formData = $request->validated();

        $jsonData = json_encode($formData);

        $client = new Client();
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/address', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('IPAddresses.index');
        } catch (\Exception $e) {
            return dd($e->getMessage());
        }
    }
}
