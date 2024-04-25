<?php

namespace App\Http\Controllers;

use App\Models\Device;
use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class InterfacesController extends Controller
{
    public function index(Request $request): View
    {
        if ($request->route('Device') != null) {
            $device = Device::findOrFail($request->route('Device'));
        } else {
            abort(404);
        }

        try {
            $client = new Client();

            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            
            $response = $client->get($device['method'] . "://" . $device['endpoint'] . "/rest/interface/wireless", [
                'auth' => [$device['username'], $device['password']],
                'timeout' => $device['timeout']
            ]);

            $data_wireless = json_decode($response->getBody(), true);
            usort($data_wireless, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            
            return view('interfaces.index', ['interfaces' => $data, 'wireless' => $data_wireless, 'deviceParam' => $device['id']]);
        } catch (\Exception $e) {
            return view('interfaces.index', ['interfaces' => "-1", 'wireless' => "-1", 'conn_error' => $e->getMessage(), 'deviceParam' => $device['id']]);
        }
    }
}
