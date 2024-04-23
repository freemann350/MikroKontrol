<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(): View
    {
        $devices = Auth::user()->devices;
        if ($devices->isEmpty())
            $devices = null;

        $client = new Client();

        if ($devices != null) {
            foreach($devices as $device) {
                try {
                    $response = $client->request('get', $device['method']."://".$device['endpoint']."/rest/system/resource", [
                        'auth' => [$device['username'], $device['password']],
                        'headers' => ['Content-Type' => 'application/json'],
                        'timeout' => 0.5
                    ]);
        
                    $device['online'] = $response->getStatusCode();
                } catch (\Exception $e) {
                    $device['online'] = null;
                }
            }
        }

        return view('dashboard.index',['devices'=> $devices]);
    }
    
    public function indexDevice($deviceId): View
    {
        $device = Device::findOrFail($deviceId);
        
        $client = new Client();

        try {
            $response = $client->request('get', $device['method']."://".$device['endpoint']."/rest/system/resource", [
                'auth' => [$device['username'], $device['password']],
                'headers' => ['Content-Type' => 'application/json'],
                'timeout' => 0.5
            ]);

            $data = json_decode($response->getBody(), true);

            return view('devices.index',['resource'=> $data, 'device'=> $device, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('devices.index', ['resource'=> null, 'device'=> $device, 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }

    public function create(): View
    {
        return view('devices.create');
    }

    public function store(DeviceRequest $request)
    {
        // Validate the incoming request data
        $formData = $request->validated();
        
        if ($formData['timeout'] == null)
            $formData['timeout'] = 3;

        // Create a new Device instance and save it to the database
        Device::create([
            'name' => $formData['name'],
            'user_id' => Auth::user()->id,
            'username' => $formData['username'],
            'password' => $formData['password'],
            'endpoint' => $formData['endpoint'],
            'method' => $formData['method'],
            'timeout' => $formData['timeout'],
        ]);

        return redirect()->route('Dashboard.index')->with('success-msg', "A Device was added with success");
    }

    public function edit($id): View
    {
        $device = Device::findOrFail($id);
        return view('devices.edit', ['device' => $device]);
    }

    public function update(DeviceRequest $request,$id)
    {
        // Validate the incoming request data
        $formData = $request->validated();

        if ($formData['timeout'] == null)
            $formData['timeout'] = 3;

        // Create a new Device instance and save it to the database
        $device = Device::findOrFail($id);
        $device->update($formData);

        return redirect()->route('Dashboard.index')->with('success-msg', "A Device was added with success");
    }

    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect()->route('Dashboard.index')->with('success-msg', "A Device was added with success");
    }
}
