<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\BridgeRequest;
class BridgeController extends Controller
{
    public function index($deviceId): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            
            return view('bridges.index', ['bridges' => $data, 'deviceParam' => $device['id']]);
            
        } catch (\Exception $e) {
            return view('bridges.index', ['bridges' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function show($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

            return view('bridges.show', ['bridge' => $data, 'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('bridges.index', ['bridges' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }
    
    public function create($deviceId): View 
    {
        $device = Device::findOrFail($deviceId);

        return view("bridges.create", ['deviceParam' => $device['id']]);
    }

    public function store($deviceId, BridgeRequest $request): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);


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
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('Bridges.index', $device['id'])->with('success-msg', "A Bridge interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeCustom($deviceId, CustomRequest $request): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);


        $formData = $request->validated();

        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('Bridges.index', $device['id'])->with('success-msg', "A Bridge interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function edit($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        $client = new Client();
        
        try {
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);

            return view('bridges.edit', ['bridge' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('bridges.index', ['bridges' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function update(BridgeRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

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
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('Bridges.index', $device['id'])->with('success-msg', "A Bridge interface was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateCustom(CustomRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('Bridges.index', $device['id'])->with('success-msg', "A Bridge interface was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroy($deviceId, $id) 
    {
        $device = Device::findOrFail($deviceId);

        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/bridge/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('Bridges.index', $device['id'])->with('success-msg', "A Bridge interface was deleted with success");
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
