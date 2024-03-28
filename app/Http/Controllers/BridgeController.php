<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\BridgeRequest;
class BridgeController extends Controller
{
    public function index(): View
    {
        $client = new Client();
        try {
            $response = $client->get('http://192.168.88.1/rest/interface/bridge', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });

            return view('bridges.index', ['bridges' => $data]);
            
        } catch (\Exception $e) {
            return abort(500);
        }
    }
    
    public function create(): View {
        return view("bridges.create");
    }

    public function store(BridgeRequest $request): View {
        $formData = $request->validated();
        $jsonData = json_encode($formData);

        $client = new Client();
        try {
            $response = $client->request('PUT', 'http://192.168.88.1/rest/interface/bridge', [
                'auth' => ['admin', '123456'],
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $jsonData,
                'timeout' => 3
            ]);

            return $this->index();
        } catch (\Exception $e) {
            return abort(500);
        }
    }
}
