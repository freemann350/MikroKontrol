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

        if (isset($formData["dhcp-snooping"]))
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

            return redirect()->route('Bridges.index')->with('success-msg', "A Bridge interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function edit($id): View
    {
        
        $client = new Client();
        
        try {
            $response = $client->get("http://192.168.88.1/rest/interface/bridge/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);

            return view('bridges.edit', ['bridge' => $data]);
        } catch (\Exception $e) {
            return view('bridges.index', ['bridges' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function update(BridgeRequest $request, $id): RedirectResponse
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

        if (isset($formData["dhcp-snooping"]))
            $formData["dhcp-snooping"] = "true";

        $jsonData = json_encode($formData);
        
        $client = new Client();

        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/interface/bridge/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);
            
            return redirect()->route('Bridges.index')->with('success-msg', "A Bridge interface was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroy($id) 
    {
        $client = new Client();

        try {
            $response = $client->request('DELETE', "http://192.168.88.1/rest/interface/bridge/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('Bridges.index')->with('success-msg', "A Bridge interface was deleted with success");
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
