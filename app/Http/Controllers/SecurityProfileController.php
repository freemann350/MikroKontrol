<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomRequest;
use App\Http\Requests\SecurityProfileRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class SecurityProfileController extends Controller
{
    public function index($deviceId): View
    {       
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
    
            return view('security_profiles.index', ['security_profiles' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('security_profiles.index', ['security_profiles' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function create($deviceId): View {
        $device = Device::findOrFail($deviceId);
        
        return view("security_profiles.create", ['deviceParam' => $device['id']]);
    }

    public function store(SecurityProfileRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();

        if ($formData['wpa2-pre-shared-key'] == null)
            unset($formData['wpa2-pre-shared-key']);

        if ($formData['supplicant-identity'] == null)
            unset($formData['supplicant-identity']);

        if ($formData['group-key-update'] == null)
            unset($formData['group-key-update']);

        if ($formData['management-protection-key'] == null)
            unset($formData['management-protection-key']);

        if (isset($formData['wpa2-psk']) && isset($formData['wpa2-eap'])) {
            $formData['authentication-types'] = "wpa2-psk,wpa2-eap";
            unset($formData['wpa2-psk']);
            unset($formData['wpa2-eap']);
        } elseif (isset($formData['wpa2-psk'])) {
            $formData['authentication-types'] = "wpa2-psk";
            unset($formData['wpa2-psk']);
        } elseif (isset($formData['wpa2-eap'])) {
            $formData['authentication-types'] = "wpa2-eap";
            unset($formData['wpa2-eap']);
        }

        if (isset($formData['uc-aes-ccm']) && isset($formData['uc-tkip'])) {
            $formData['unicast-ciphers'] = "aes-ccm,tkip";
            unset($formData['uc-aes-ccm']);
            unset($formData['uc-tkip']);
        } elseif (isset($formData['uc-aes-ccm'])) {
            $formData['unicast-ciphers'] = "aes-ccm";
            unset($formData['uc-aes-ccm']);
        } elseif (isset($formData['uc-tkip'])) {
            $formData['unicast-ciphers'] = "tkip";
            unset($formData['uc-tkip']);
        } else {
            $formData['unicast-ciphers'] = "";
        }

        if (isset($formData['gc-aes-ccm']) && isset($formData['gc-tkip'])) {
            $formData['group-ciphers'] = "aes-ccm,tkip";
            unset($formData['gc-aes-ccm']);
            unset($formData['gc-tkip']);
        } elseif (isset($formData['gc-aes-ccm'])) {
            $formData['group-ciphers'] = "aes-ccm";
            unset($formData['gc-aes-ccm']);
        } elseif (isset($formData['gc-tkip'])) {
            $formData['group-ciphers'] = "tkip";
            unset($formData['gc-tkip']);
        } else {
            $formData['group-ciphers'] = "";
        }

        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('SecurityProfiles.index',$device['id'])->with('success-msg', "A Security Profile was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }
    
    
    public function storeCustom(CustomRequest $request, $deviceId): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();
        
        try {
            $response = $client->request('PUT', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('SecurityProfiles.index',$device['id'])->with('success-msg', "A Security Profile was added with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function edit($deviceId, $id): View {
        $device = Device::findOrFail($deviceId);

        try {
            $client = new Client();
    
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles/$id", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
    
            return view('security_profiles.edit', ['security_profile' => $data, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('security_profiles.index', ['security_profiles' => null, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function update(SecurityProfileRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();

        if ($formData['wpa2-pre-shared-key'] == null)
            unset($formData['wpa2-pre-shared-key']);

        if ($formData['supplicant-identity'] == null)
            unset($formData['supplicant-identity']);

        if ($formData['group-key-update'] == null)
            unset($formData['group-key-update']);

        if ($formData['management-protection-key'] == null)
            unset($formData['management-protection-key']);

        if (isset($formData['wpa2-psk']) && isset($formData['wpa2-eap'])) {
            $formData['authentication-types'] = "wpa2-psk,wpa2-eap";
            unset($formData['wpa2-psk']);
            unset($formData['wpa2-eap']);
        } elseif (isset($formData['wpa2-psk'])) {
            $formData['authentication-types'] = "wpa2-psk";
            unset($formData['wpa2-psk']);
        } elseif (isset($formData['wpa2-eap'])) {
            $formData['authentication-types'] = "wpa2-eap";
            unset($formData['wpa2-eap']);
        }

        if (isset($formData['uc-aes-ccm']) && isset($formData['uc-tkip'])) {
            $formData['unicast-ciphers'] = "aes-ccm,tkip";
            unset($formData['uc-aes-ccm']);
            unset($formData['uc-tkip']);
        } elseif (isset($formData['uc-aes-ccm'])) {
            $formData['unicast-ciphers'] = "aes-ccm";
            unset($formData['uc-aes-ccm']);
        } elseif (isset($formData['uc-tkip'])) {
            $formData['unicast-ciphers'] = "tkip";
            unset($formData['uc-tkip']);
        } else {
            $formData['unicast-ciphers'] = "";
        }

        if (isset($formData['gc-aes-ccm']) && isset($formData['gc-tkip'])) {
            $formData['group-ciphers'] = "aes-ccm,tkip";
            unset($formData['gc-aes-ccm']);
            unset($formData['gc-tkip']);
        } elseif (isset($formData['gc-aes-ccm'])) {
            $formData['group-ciphers'] = "aes-ccm";
            unset($formData['gc-aes-ccm']);
        } elseif (isset($formData['gc-tkip'])) {
            $formData['group-ciphers'] = "tkip";
            unset($formData['gc-tkip']);
        } else {
            $formData['group-ciphers'] = "";
        }

        $jsonData = json_encode($formData);

        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => $device['timeout']
            ]);

            return redirect()->route('SecurityProfiles.index', $device['id'])->with('success-msg', "A Security Profile was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function updateCustom(CustomRequest $request, $deviceId, $id): RedirectResponse
    {
        $device = Device::findOrFail($deviceId);

        $formData = $request->validated();
        
        $client = new Client();

        try {
            $response = $client->request('PATCH', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $formData['custom'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('SecurityProfiles.index', $device['id'])->with('success-msg', "A Security Profile was updated with success");
        } catch (\Exception $e) {
            $error = $this->treat_error($e->getMessage());

            if ($error == null)
                dd($e->getMessage());

            return redirect()->back()->withInput()->with('error-msg', $error);
        }
    }

    public function destroy($deviceId, $id) {
        $device = Device::findOrFail($deviceId);

        $client = new Client();

        try {
            $response = $client->request('DELETE', $device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless/security-profiles/$id", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => $device['timeout']
            ]);
            
            return redirect()->route('SecurityProfiles.index', $device['id'])->with('success-msg', "A Security Profile was deleted with success");
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
