<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\DhcpClientRequest;
use App\Http\Requests\DhcpServerRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class DhcpController extends Controller
{
    public function servers($deviceId): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);
           
            return view('dhcp.servers', ['servers' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.servers', ['servers' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function showDhcpServer($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);
           
            return view('dhcp.showServer', ['server' => $data, 'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.servers', ['servers' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function createDhcpServer($deviceId): View 
    {
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

            return view("dhcp.create_server",['interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.servers', ['servers' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function storeDhcpServer(DhcpServerRequest $request, $deviceId): RedirectResponse 
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        if ($formData['relay'] == null)
            unset($formData['relay']);

        if ($formData['lease-time'] == null)
            unset($formData['lease-time']);

        if (!isset($formData['use-framed-as-classless']))
            $formData['use-framed-as-classless'] = "false";

        if (!isset($formData['conflict-detection']))
            $formData['conflict-detection'] = "false";
        
        
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dhcp_servers', $device['id'])->with('success-msg', "A DHCP Server was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeServerCustom(CustomRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dhcp_servers', $device['id'])->with('success-msg', "A DHCP Server was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editDhcpServer($deviceId, $id): View 
    {
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
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
            $server = json_decode($response->getBody(), true);

            return view("dhcp.edit_server",['server' => $server,'interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.servers', ['servers' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function updateDhcpServer(DhcpServerRequest $request, $deviceId, $id): RedirectResponse 
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        if ($formData['relay'] == null)
            unset($formData['relay']);

        if ($formData['lease-time'] == null)
            unset($formData['lease-time']);

        if (!isset($formData['always-broadcast']))
            $formData['always-broadcast'] = "false";

        if (!isset($formData['add-arp']))
            $formData['add-arp'] = "false";
        
            if (!isset($formData['use-framed-as-classless']))
            $formData['use-framed-as-classless'] = "false";

        if (!isset($formData['conflict-detection']))
            $formData['conflict-detection'] = "false";
        
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dhcp_servers', $device['id'])->with('success-msg', "A DHCP Server was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateServerCustom(CustomRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dhcp_servers', $device['id'])->with('success-msg', "A DHCP Server was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }
    public function destroyDhcpServer($deviceId, $id) 
    {
        $device = Device::findOrFail($deviceId);

        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-server/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dhcp_servers', $device['id'])->with('success-msg', "A DHCP Server was deleted with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function client($deviceId): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view('dhcp.clients', ['clients' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.clients', ['clients' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function showDhcpClient($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);
 
            return view('dhcp.showClient', ['client' => $data, 'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.clients', ['clients' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function createDhcpClient($deviceId): View 
    {
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

            return view("dhcp.create_client",['interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.clients', ['clients' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function storeDhcpClient(DhcpClientRequest $request, $deviceId): RedirectResponse 
    {

        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        if (!isset($formData['use-peer-dns']))
            $formData['use-peer-dns'] = "false";

        if (!isset($formData['use-peer-ntp']))
            $formData['use-peer-ntp'] = "false";
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dhcp_client', $device['id'])->with('success-msg', "A DHCP Client was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    
    public function storeClientCustom(CustomRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dhcp_client', $device['id'])->with('success-msg', "A DHCP Client was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editDhcpClient($deviceId, $id): View 
    {
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
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $client = json_decode($response->getBody(), true);

            return view('dhcp.edit_client', ['client' => $client,'interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dhcp.clients', ['clients' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function updateDhcpClient(DhcpClientRequest $request, $deviceId, $id): RedirectResponse 
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();

        if (!isset($formData['use-peer-dns']))
            $formData['use-peer-dns'] = "false";

        if (!isset($formData['use-peer-ntp']))
            $formData['use-peer-ntp'] = "false";

        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dhcp_client', $device['id'])->with('success-msg', "A DHCP Client was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateClientCustom(CustomRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dhcp_client', $device['id'])->with('success-msg', "A DHCP Client was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyDhcpClient($deviceId, $id) 
    {
        $device = Device::findOrFail($deviceId);

        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dhcp-client/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dhcp_client', $device['id'])->with('success-msg', "A DHCP Client was deleted with success");
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
