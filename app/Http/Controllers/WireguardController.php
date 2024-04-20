<?php

namespace App\Http\Controllers;

use App\Http\Requests\WireguardServerRequest;
use App\Http\Requests\WireguardClientRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use GuzzleHttp\Client;

class WireguardController extends Controller
{
    public function servers(): View
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

            return view('wireguard.servers', ['wg' => $data]);
            
        } catch (\Exception $e) {
            return view('wireguard.servers', ['wg' => "-1", 'conn_error' => $e->getMessage()]);
        }
    }

    public function createServer(): View 
    {
        return view('wireguard.create_server');
    }

    public function storeServer(WireguardServerRequest $request): RedirectResponse
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

            return redirect()->route('wireguard_servers')->with('success-msg', "A Wireguard Interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editServer($id): View 
    {
        try {
            $client = new Client();

            $response = $client->get("http://192.168.88.1/rest/interface/wireguard/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $wg = json_decode($response->getBody(), true);

            return view('wireguard.edit_server',['wg' => $wg]);
        } catch (\Exception $e) {
            return view('wireguard.servers', ['wg' => "-1", 'conn_error' => $e->getMessage()]);
        }
    }

    public function updateServer(WireguardServerRequest $request, $id): RedirectResponse
    {
        $formData = $request->validated();
        
        if ($formData['mtu'] == null)
            unset($formData['mtu']);
        
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/interface/wireguard/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('wireguard_servers')->with('success-msg', "A wireguard interface was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyServer($id) 
    {
        $client = new Client();

        try {
            $response = $client->request('DELETE', "http://192.168.88.1/rest/interface/wireguard/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('wireguard_servers')->with('success-msg', "A Wireguard interface was deleted with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function clients(): View
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireguard/peers', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view('wireguard.clients', ['wg' => $data]);
            
        } catch (\Exception $e) {
            return view('wireguard.clients', ['wg' => "-1", 'conn_error' => $e->getMessage()]);
        }
    }

    public function createClient(): View 
    {
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

            return view("wireguard.create_client",['interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('wireguard.create_client', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }

    }

    public function storeClient(WireguardClientRequest $request): RedirectResponse
    {
        $formData = $request->validated();

        if (!isset($formData['private-key']))
            unset($formData['private-key']);
        
        if (isset($formData['auto-pk']))
        {
            $formData['private-key'] = 'auto';
            unset($formData['auto-pk']);
        }
        if (!isset($formData['endpoint-address']))
            unset($formData['endpoint-address']);

        if (!isset($formData['endpoint-port']))
            unset($formData['endpoint-port']);

        if (!isset($formData['allowed-address']))
            unset($formData['allowed-address']);

        if (!isset($formData['preshared-key']))
            unset($formData['preshared-key']);

        if (isset($formData['auto-psk']))
        {
            $formData['private-key'] = 'auto';
            unset($formData['auto-psk']);
        }

        if (!isset($formData['persistent-keepalive']))
            unset($formData['persistent-keepalive']);
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/interface/wireguard/peers', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('wireguard_clients')->with('success-msg', "A Wireguard Peer was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editClient($id): View 
    {
        try {
            $client = new Client();

            $response = $client->get("http://192.168.88.1/rest/interface/wireguard/peers/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $wg = json_decode($response->getBody(), true);

            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view("wireguard.edit_client",['wg' => $wg, 'interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('wireguard.edit_client', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function updateClient(WireguardClientRequest $request, $id): RedirectResponse
    {
        $formData = $request->validated();
        
        if (!isset($formData['private-key']))
            unset($formData['private-key']);
        
        if (isset($formData['auto-pk'])) 
        {
            $formData['private-key'] = 'auto';
            unset($formData['auto-pk']);
        }
        
        if (!isset($formData['endpoint-address']))
            unset($formData['endpoint-address']);

        if (!isset($formData['endpoint-port']))
            unset($formData['endpoint-port']);

        if (!isset($formData['allowed-address']))
            unset($formData['allowed-address']);

        if (!isset($formData['preshared-key']))
            unset($formData['preshared-key']);
        
        if (isset($formData['auto-psk'])) 
        {
            $formData['private-key'] = 'auto';
            unset($formData['auto-psk']);
        }
        
        if (!isset($formData['persistent-keepalive']))
            unset($formData['persistent-keepalive']);

        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/interface/wireguard/peers/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('wireguard_clients')->with('success-msg', "A Wireguard Peer was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyClient($id) 
    {
        $client = new Client();

        try {
            $response = $client->request('DELETE', "http://192.168.88.1/rest/interface/wireguard/peers/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('wireguard_clients')->with('success-msg', "A Wireguard Peer was deleted with success");
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
