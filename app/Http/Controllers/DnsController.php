<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\DnsServerRequest;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\DnsRecordRequest;

class DnsController extends Controller
{
    public function server(): View
    {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dns', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view('dns.server', ['server' => $data]);
        } catch (\Exception $e) {
            return view('dns.server', ['server' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function editDnsServer(): View {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dns', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view("dns.edit_server", ['server' => $data]);
        } catch (\Exception $e) {
            return view('dns.server', ['server' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function storeDnsServer(DnsServerRequest $request) : RedirectResponse
    {
        $formData = $request->validated();
        if ($formData['servers'] == null)
            $formData['servers'] = "";

        if ($formData['use-doh-server'] == null)
            $formData['use-doh-server'] = "";

        $jsonData = json_encode($formData);
        
        $client = new Client();
        try {
            $response = $client->request('POST', 'http://192.168.88.1/rest/ip/dns/set', [
                'auth' => ['admin', '123456'], 
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('dns_server')->with('success-msg', "The DNS Server was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeServerCustom(CustomRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('POST', 'http://192.168.88.1/rest/ip/dns/set', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);
            
            return redirect()->route('dns_server')->with('success-msg', "The DNS Server was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }
    public function records(): View
    {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dns/static', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
    
            return view('dns.records', ['records' => $data]);
        } catch (\Exception $e) {
            return view('dns.records', ['records' => "-1", 'conn_error' => $e->getMessage()]);
        }
    }

    public function createDnsRecord(): View {
        return view("dns.create_record");
    }

    public function storeDnsRecord(DnsRecordRequest $request) : RedirectResponse
    {
        $formData = $request->validated();
        $formData["type"] = "A";
        $jsonData = json_encode($formData);
        
        $client = new Client();
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/dns/static', [
                'auth' => ['admin', '123456'], 
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('dns_records')->with('success-msg', "A DNS Static Record was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function storeRecordCustom(CustomRequest $request): RedirectResponse
    {
        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/dns/static', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);

            return redirect()->route('dns_records')->with('success-msg', "A DNS Static Record was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function editDnsRecord($id): View {
        try {
            $client = new Client();
    
            $response = $client->get("http://192.168.88.1/rest/ip/dns/static/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view("dns.edit_record", ['record' => $data]);
        } catch (\Exception $e) {
            return view('dns.records', ['record' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function updateDnsRecord(DnsRecordRequest $request, $id): RedirectResponse 
    {
        $formData = $request->validated();
        $formData["type"] = "A";
        $jsonData = json_encode($formData);
        
        $client = new Client();
        try {
            $response = $client->request('PUT', "http://192.168.88.1/rest/ip/dns/static/$id", [
                'auth' => ['admin', '123456'], 
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('dns_records')->with('success-msg', "A DNS Static Record was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateRecordCustom(CustomRequest $request, $id): RedirectResponse
    {
        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PUT', "http://192.168.88.1/rest/ip/dns/static/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => 3
            ]);
            
            return redirect()->route('dns_records')->with('success-msg', "A DNS Static Record was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroyDnsRecord($id) 
    {
        $client = new Client();

        try {
            $response = $client->request('DELETE', "http://192.168.88.1/rest/ip/dns/static/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('dns_records')->with('success-msg', "A Static DNS Record was deleted with success");
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
