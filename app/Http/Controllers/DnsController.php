<?php

namespace App\Http\Controllers;

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

    public function storeDnsServer(DnsRecordRequest $request) : View
    {
        return view(null);
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
            return view('dns.records', ['records' => null, 'conn_error' => $e->getMessage()]);
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

            return redirect()->route('dns_records');
        } catch (\Exception $e) {
            return abort(500);
        }
    }
}
