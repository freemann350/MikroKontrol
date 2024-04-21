<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\StaticRouteRequest;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class StaticRouteController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/ip/route', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            return view('static_routes.index', ['routes' => $data]);
        } catch (\Exception $e) {
            return view('static_routes.index', ['routes' => null, 'conn_error' => $e->getMessage()]);
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

            return view("static_routes.create",['interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('static_routes.create', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function store(StaticRouteRequest $request): RedirectResponse
    {
        $formData = $request->validated();
                
        if ($formData['distance'] == null)
            unset($formData['distance']);
    
        if ($formData['scope'] == null)
            unset($formData['scope']);

        if ($formData['target-scope'] == null)
            unset($formData['target-scope']);
        
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/route', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('StaticRoutes.index')->with('success-msg', "A Static Route was added with success");
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
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/route', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);

            return redirect()->route('StaticRoutes.index')->with('success-msg', "A Static Route was added with success");
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

            $response = $client->get("http://192.168.88.1/rest/ip/route/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $route = json_decode($response->getBody(), true);

            return view("static_routes.edit",['route' => $route,'interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('static_routes.edit', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function update(StaticRouteRequest $request, $id): RedirectResponse
    {
        $formData = $request->validated();
                
        if ($formData['distance'] == null)
            unset($formData['distance']);
    
        if ($formData['scope'] == null)
            unset($formData['scope']);

        if ($formData['target-scope'] == null)
            unset($formData['target-scope']);

        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/ip/route/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('StaticRoutes.index')->with('success-msg', "A Static Route was added with success");
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
            $response = $client->request('PATCH', "http://192.168.88.1/rest/ip/route/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);
            
            return redirect()->route('StaticRoutes.index')->with('success-msg', "A Static Route was added with success");
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
            $response = $client->request('DELETE', "http://192.168.88.1/rest/ip/route/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('StaticRoutes.index')->with('success-msg', "A Static Route was deleted with success");
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
