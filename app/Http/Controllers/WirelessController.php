<?php

namespace App\Http\Controllers;

use App\Http\Requests\WirelessRequest;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
class WirelessController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireless', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);
            $data = json_decode($response->getBody(), true);

            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            return view('wireless.index', ['wireless' => $data]);
        } catch (\Exception $e) {
            return view('wireless.index', ['wireless' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function create(): View {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireless', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireless/security-profiles', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $security_profiles = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view("wireless.create",['interfaces' => $interfaces, 'security_profiles' => $security_profiles]);
        } catch (\Exception $e) {
            return view('wireless.create', ['interfaces' => null, 'conn_error' => $e->getMessage()]);
        }
    }

    public function store(WirelessRequest $request) {
        
        $formData = $request->validated();
        
        $formData['mode'] = "ap-bridge";

        if (!isset($formData['default-authentication']))
            $formData['default-authentication'] = "false";

        if (!isset($formData['default-forwarding']))
            $formData['default-forwarding'] = "false";
        
        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/interface/wireless', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('Wireless.index')->with('success-msg', "A Wireless interface was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function edit($id): View 
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireless', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $interfaces = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface/wireless/security-profiles', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $security_profiles = json_decode($response->getBody(), true);
            
            usort($interfaces, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            $client = new Client();

            $response = $client->get("http://192.168.88.1/rest/interface/wireless/$id", [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $wireless = json_decode($response->getBody(), true);

            return view('wireless.edit',['wireless' => $wireless, 'interfaces' => $interfaces, 'security_profiles' => $security_profiles]);
        } catch (\Exception $e) {
            return view('wireless.edit', ['wireless' => "-1", 'conn_error' => $e->getMessage()]);
        }
    }

    public function update(WirelessRequest $request, $id): RedirectResponse
    {
        $formData = $request->validated();
        
        $formData['mode'] = "ap-bridge";

        if (!isset($formData['default-authentication']))
            $formData['default-authentication'] = "false";

        if (!isset($formData['default-forwarding']))
            $formData['default-forwarding'] = "false";
                
        $jsonData = json_encode($formData);

        $client = new Client();
        
        try {
            $response = $client->request('PATCH', "http://192.168.88.1/rest/interface/wireless/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return redirect()->route('Wireless.index')->with('success-msg', "A Wireless interface was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }


    public function destroy($id) 
    {
        $client = new Client();

        try {
            $response = $client->request('DELETE', "http://192.168.88.1/rest/interface/wireless/$id", [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 3
            ]);
            
            return redirect()->route('Wireless.index')->with('success-msg', "A Wireless interface was deleted with success");
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
