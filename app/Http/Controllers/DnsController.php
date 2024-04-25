<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\DnsServerRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\DnsRecordRequest;

class DnsController extends Controller
{
    public function server($deviceId): View
    {
        $device = Device::findOrFail($deviceId);
        
        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view('dns.server', ['server' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dns.server', ['server' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function editDnsServer($deviceId): View {
        $device = Device::findOrFail($deviceId);
        
        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view("dns.edit_server", ['server' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dns.server', ['server' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function storeDnsServer(DnsServerRequest $request, $deviceId) : RedirectResponse
    {
        $device = Device::findOrFail($deviceId);
        
        $formData = $request->validated();
        if ($formData['servers'] == null)
            $formData['servers'] = "";

        if ($formData['use-doh-server'] == null)
            $formData['use-doh-server'] = "";

        $jsonData = json_encode($formData);
        
        $client = new Client();
        try {
            $response = $client->request('POST', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/set", [
                'auth' => [$device['username'], $device['password']], 
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dns_server', $device['id'])->with('success-msg', "The DNS Server was updated with success");
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
            $response = $client->request('POST', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/set", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dns_server', $device['id'])->with('success-msg', "The DNS Server was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }
    public function records($deviceId): View
    {
        $device = Device::findOrFail($deviceId);
        
        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
    
            return view('dns.records', ['records' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dns.records', ['records' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function showDnsRecord($deviceId, $id): View
    {
        $device = Device::findOrFail($deviceId);
        
        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            
            $json = json_encode($data, JSON_PRETTY_PRINT);

    
            return view('dns.showRecord', ['record' => $data,'json' => $json, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dns.records', ['records' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function createDnsRecord($deviceId): View {
        $device = Device::findOrFail($deviceId);
        
        return view("dns.create_record", ['deviceParam' => $device['id']]);
    }

    public function storeDnsRecord(DnsRecordRequest $request, $deviceId) : RedirectResponse
    {
        $device = Device::findOrFail($deviceId);
        
        $formData = $request->validated();
        $formData["type"] = "A";
        $jsonData = json_encode($formData);
        
        $client = new Client();
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static", [
                'auth' => [$device['username'], $device['password']], 
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dns_records', $device['id'])->with('success-msg', "A DNS Static Record was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeRecordCustom(CustomRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);
        
        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dns_records', $device['id'])->with('success-msg', "A DNS Static Record was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editDnsRecord($deviceId, $id): View {
        $device = Device::findOrFail($deviceId);
        
        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view("dns.edit_record", ['record' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('dns.records', ['records' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function updateDnsRecord(DnsRecordRequest $request, $deviceId, $id): RedirectResponse 
    {
        $device = Device::findOrFail($deviceId);
        
        $formData = $request->validated();
        $formData["type"] = "A";
        $jsonData = json_encode($formData);
        
        $client = new Client();
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static/$id", [
                'auth' => [$device['username'], $device['password']], 
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('dns_records', $device['id'])->with('success-msg', "A DNS Static Record was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateRecordCustom(CustomRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);
        
        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dns_records', $device['id'])->with('success-msg', "A DNS Static Record was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyDnsRecord($deviceId, $id) 
    {
        $device = Device::findOrFail($deviceId);
        
        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/ip/dns/static/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('dns_records', $device['id'])->with('success-msg', "A Static DNS Record was deleted with success");
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
