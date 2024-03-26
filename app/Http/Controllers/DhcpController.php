<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class DhcpController extends Controller
{
    public function servers(): View
    {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dhcp-server', [
                'auth' => ['admin', '123456']
            ]);
    
            $data = json_decode($response->getBody(), true);
           
            return view('dhcp.servers', ['servers' => $data]);
        } catch (RequestException $e) {
            return abort(500);
        }
    }

    public function client(): View
    {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dhcp-client', [
                'auth' => ['admin', '123456']
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view('dhcp.clients', ['clients' => $data]);
        } catch (RequestException $e) {
            return abort(500);
        }
    }
}
