<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
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
        return view("wireless.create");
    }
}
