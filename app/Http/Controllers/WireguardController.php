<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\WireguardServerRequest;
use App\Http\Requests\WireguardClientRequest;
use App\Models\Device;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use GuzzleHttp\Client;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WireguardController extends Controller
{
    public function servers($deviceId): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view('wireguard.servers', ['wg' => $data, 'deviceParam' => $device['id']]);
            
        } catch (\Exception $e) {
            return view('wireguard.servers', ['wg' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function showServer($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

            return view('wireguard.showServer', ['wg' => $data, 'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('wireguard.showServer', ['wg' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function createServer($deviceId): View 
    {
        $device = Device::findOrFail($deviceId);

        return view('wireguard.create_server', ['deviceParam' => $device['id']]);
    }

    public function storeServer(WireguardServerRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        if ($formData['mtu'] == null)
            unset($formData['mtu']);
        
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('wireguard_servers', $device['id'])->with('success-msg', "A Wireguard Interface was added with success");
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
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('wireguard_servers', $device['id'])->with('success-msg', "A Wireguard Interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editServer($deviceId, $id): View 
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $wg = json_decode($response->getBody(), true);

            return view('wireguard.edit_server',['wg' => $wg, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('wireguard.servers', ['wg' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function updateServer(WireguardServerRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        if ($formData['mtu'] == null)
            unset($formData['mtu']);
        
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('wireguard_servers', $device['id'])->with('success-msg', "A wireguard interface was updated with success");
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
            $response = $client->request('PATCH',$device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('wireguard_servers', $device['id'])->with('success-msg', "A wireguard interface was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyServer($deviceId, $id) 
    {
        $device = Device::findOrFail($deviceId);

        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('wireguard_servers', $device['id'])->with('success-msg', "A Wireguard interface was deleted with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function clients($deviceId): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            foreach ($data as &$val) {
                if ($val['private-key'] != "") {
                    $qrcode = $this->qrcode($val['private-key'] ?? null, $val['public-key'] ?? null, $val['preshared-key'] ?? null, $val['allowed-address'] ?? null, $val['endpoint-address'] ?? null, $val['endpoint-port'] ?? null, $val['persistent-keepalive'] ?? null);
                    $val['qrcode'] = $qrcode;
                }
            }
            
            return view('wireguard.clients', ['wg' => $data, 'deviceParam' => $device['id']]);
            
        } catch (\Exception $e) {
            return view('wireguard.clients', ['wg' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function showClient($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

            return view('wireguard.showClient', ['wg' => $data, 'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('wireguard.showClient', ['wg' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function createClient($deviceId): View 
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

            return view("wireguard.create_client",['interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('wireguard.create_client', ['interfaces' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }

    }

    public function storeClient(WireguardClientRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

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
            $formData['preshared-key'] = 'auto';
            unset($formData['auto-psk']);
        }

        if (!isset($formData['persistent-keepalive']))
            unset($formData['persistent-keepalive']);

        
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('wireguard_clients', $device['id'])->with('success-msg', "A Wireguard Peer was added with success");
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
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('wireguard_clients', $device['id'])->with('success-msg', "A Wireguard Peer was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editClient($deviceId, $id): View 
    {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $wg = json_decode($response->getBody(), true);

            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view("wireguard.edit_client",['wg' => $wg, 'interfaces' => $interfaces, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('wireguard.edit_client', ['interfaces' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function updateClient(WireguardClientRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

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
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('wireguard_clients', $device['id'])->with('success-msg', "A Wireguard Peer was updated with success");
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
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('wireguard_clients', $device['id'])->with('success-msg', "A Wireguard Peer was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyClient($deviceId, $id) 
    {
        $device = Device::findOrFail($deviceId);

        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireguard/peers/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('wireguard_clients', $device['id'])->with('success-msg', "A Wireguard Peer was deleted with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function qrcode($prk,$puk,$psk,$ips,$endpoint,$port,$keepalive)
    {
        if ($prk != null) {
            $QrPrivateKey = "PrivateKey = $prk";
        } else {
            $QrPrivateKey = null;
        }

        if ($puk != null) {
            $QrPublicKey = "PublicKey = $puk";
        } else {
            $QrPublicKey = null;
        }
        
        if ($psk != null){
            $QrPresharedKey = "PresharedKey = $psk";
        } else {
            $QrPresharedKey = null;
        }
        
        if ($ips != null){
            $QrAllowedIPs = "AllowedIPs = $ips";
        } else {
            $QrAllowedIPs = null;
        }

        if ($endpoint != null && $port != null){
            $QrEndpoint = "Endpoint = " . $endpoint . ":" . $port;
        } else {
            $QrEndpoint = null;
        }

        $conf = "
        [Interface]<br>
        $QrPrivateKey<br>
        
        <br>[Peer]<br>
        $QrPublicKey<br>
        $QrPresharedKey<br>
        $QrAllowedIPs<br>
        $QrEndpoint<br>
        ";

        $qrCode = QrCode::size(150)->generate("
        [Interface]
        $QrPrivateKey
        
        [Peer]
        $QrPublicKey
        $QrPresharedKey
        $QrAllowedIPs
        $QrEndpoint
        ");

        return view('qrcode',['qrCode' => $qrCode, 'conf' => $conf]);
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
