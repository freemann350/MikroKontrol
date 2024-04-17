<?php

namespace App\Http\Controllers;

use App\Http\Requests\DhcpClientRequest;
use App\Http\Requests\DhcpServerRequest;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
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

    public function createDhcpServer(): View 
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

            return view("dhcp.create_server",['interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('dhcp.create_server', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function storeDhcpServer(DhcpServerRequest $request): RedirectResponse 
    {
        $formData = $request->validated();
        
        if ($formData['relay'] == null)
            unset($formData['relay']);

        if ($formData['lease-time'] == null)
            unset($formData['lease-time']);

        if ($formData['comment'] == null)
            unset($formData['comment']);

        if (!isset($formData['use-framed-as-classless']))
            $formData['use-framed-as-classless'] = "false";

        if (!isset($formData['conflict-detection']))
            $formData['conflict-detection'] = "false";
        
        
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/dhcp-server', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('dhcp_servers')->with('success-msg', "A DHCP Server was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
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

    public function createDhcpClient(): View 
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

            return view("dhcp.create_client",['interfaces' => $interfaces]);
        } catch (\Exception $e) {
            return view('dhcp.create_client', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function storeDhcpClient(DhcpClientRequest $request): RedirectResponse 
    {

        $formData = $request->validated();
        
        if ($formData['comment'] == null)
            unset($formData['comment']);

        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/ip/dhcp-client', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('dhcp_client')->with('success-msg', "A DHCP Client was added with success");
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
