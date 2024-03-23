<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class BridgeController extends Controller
{
    public function index(): View
    {
        try {
            $client = new Client();

            // GET NON WIRELESS INTERFACES
            $response = $client->get('http://192.168.88.1/rest/interface/bridge', [
                'auth' => ['admin', '123456']
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view('bridges.index', ['bridges' => $data]);
        } catch (RequestException $e) {
            return response()->view('errors.500', [], 500);
        }
    }
}
