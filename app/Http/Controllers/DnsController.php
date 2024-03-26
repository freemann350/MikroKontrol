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
                'auth' => ['admin', '123456']
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view('dns.server', ['server' => $data]);
        } catch (RequestException $e) {
            return abort(500);
        }
    }
    public function records(): View
    {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dns/static', [
                'auth' => ['admin', '123456']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
    
            return view('dns.records', ['records' => $data]);
        } catch (RequestException $e) {
            return abort(500);
        }
    }

    public function addDnsRecord(DnsRecordRequest $request) : View
    {
        $formData = $request->validated();
        $formData["type"] = "A";
        $jsonData = json_encode($formData);
        //dd($jsonData);
        // Send POST request to add DNS record
        $client = new Client();
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/dns/static', [
                'auth' => ['admin', '123456'], // Replace with your MikroTik credentials
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
            ]);

            return $this->records();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add DNS record: ' . $e->getMessage()], 500);
        }
    }
}
