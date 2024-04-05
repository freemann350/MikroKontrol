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
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
    
            $data = json_decode($response->getBody(), true);
           
            return view('dhcp.servers', ['servers' => $data]);
        } catch (\Exception $e) {
            return view('dhcp.servers', ['servers' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function createDhcpServer(): View {
        return view("dhcp.create_server");
    }

    public function client(): View
    {
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/ip/dhcp-client', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
    
            $data = json_decode($response->getBody(), true);

            return view('dhcp.clients', ['clients' => $data]);
        } catch (\Exception $e) {
            return view('dhcp.clients', ['clients' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function createDhcpClient(): View {
        return view("dhcp.create_client");
    }
}
