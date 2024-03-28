<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\View\View;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;

class SecurityProfileController extends Controller
{
    public function index(): View
    {       
        try {
            $client = new Client();
    
            $response = $client->get('http://192.168.88.1/rest/interface/wireless/security-profiles', [
                'auth' => ['admin', '123456'],
                'timeout' => 3
            ]);

            $data = json_decode($response->getBody(), true);
            usort($data, function ($a, $b) {
                return $a['.id'] <=> $b['.id'];
            });
    
            return view('security_profiles.index', ['security_profiles' => $data]);
        } catch (\Exception $e) {
            return abort(500);
        }
    }

    public function create(): View {
        return view("security_profiles.create");
    }
}
