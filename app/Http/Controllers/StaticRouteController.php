<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\StaticRouteRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StaticRouteController extends Controller
{
    public function index($deviceId): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/route", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            return view('static_routes.index', ['routes' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('static_routes.index', ['routes' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function show($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/route/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);
            
            return view('static_routes.show', ['route' => $data, 'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('static_routes.show', ['route' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function create($deviceId): View {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view("static_routes.create",['interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('static_routes.create', ['interfaces' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function store(StaticRouteRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
                
        if ($formData['distance'] == null)
            unset($formData['distance']);
    
        if ($formData['scope'] == null)
            unset($formData['scope']);

        if ($formData['target-scope'] == null)
            unset($formData['target-scope']);
        
        if (isset($formData['suppress-he-offload']))
            $formData['suppress-he-offload'] = "true";

        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/route", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('StaticRoutes.index', $device['id'])->with('success-msg', "A Static Route was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeCustom(CustomRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/route", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('StaticRoutes.index', $device['id'])->with('success-msg', "A Static Route was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function edit($deviceId, $id): View {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/route/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $route = json_decode($response->getBody(), true);

            return view("static_routes.edit",['route' => $route,'interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('static_routes.edit', ['interfaces' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function update(StaticRouteRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
                
        if ($formData['distance'] == null)
            unset($formData['distance']);
    
        if ($formData['scope'] == null)
            unset($formData['scope']);

        if ($formData['target-scope'] == null)
            unset($formData['target-scope']);
        
        if (isset($formData['suppress-he-offload']))
            $formData['suppress-he-offload'] = "true";
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/route/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('StaticRoutes.index', $device['id'])->with('success-msg', "A Static Route was added with success");
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
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/route/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('StaticRoutes.index', $device['id'])->with('success-msg', "A Static Route was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroy($deviceId, $id) {
        $device = Device::findOrFail($deviceId);
        
        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/route/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('StaticRoutes.index', $device['id'])->with('success-msg', "A Static Route was deleted with success");
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
