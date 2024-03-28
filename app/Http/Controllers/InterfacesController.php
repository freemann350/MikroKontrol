<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class InterfacesController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();

            $response = $client->get('http://192.168.88.1/rest/interface', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            
            $response = $client->get('http://192.168.88.1/rest/interface/wireless', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data_wireless = json_decode($response->getBody(), true);
            usort($data_wireless, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
            return view('interfaces.index', ['interfaces' => $data, 'wireless' => $data_wireless]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }
}
