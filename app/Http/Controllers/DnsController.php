<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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
            return abort(500);
        }
    }

    public function editDnsServer(): View {
        return view("dns.edit_server");
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
            return abort(500);
        }
    }

    public function createDnsRecord(): View {
        return view("dns.create_record");
    }

    public function storeDnsRecord(DnsRecordRequest $request) : View
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

            return $this->records();
        } catch (\Exception $e) {
            return abort(500);
        }
    }
}
