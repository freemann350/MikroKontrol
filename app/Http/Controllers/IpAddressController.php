<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
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

            return redirect()->route('IPAddresses.index')->with('success-msg', "An IP Adddress was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeCustom(CustomRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/address', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);

            return redirect()->route('IPAddresses.index')->with('success-msg', "An IP Adddress was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function edit($id): View {
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

            $client = new Client();

            $response = $client->get("http://192.168.88.1/rest/ip/address/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $address = json_decode($response->getBody(), true);

            return view("ip_addresses.edit",['address' => $address,'interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('ip_addresses.edit', ['address' => null, 'conn_error' => $e->getMessage()]);
        }
    }
    
    public function update(IpAddressRequest $request, $id): RedirectResponse 
    {
        $formData = $request->validated();

        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/ip/address/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('IPAddresses.index')->with('success-msg', "The IP Adddress was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateCustom(CustomRequest $request, $id): RedirectResponse
    {
        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/ip/address/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);
            
            return redirect()->route('IPAddresses.index')->with('success-msg', "The IP Adddress was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroy($id) {
        
        $client = new Client();

        try {
            $response = $client->request('DELETE', "http://192.168.88.1/rest/ip/address/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('IPAddresses.index')->with('success-msg', "A IP Address was deleted with success");
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
