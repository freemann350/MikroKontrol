<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class WireguardController extends Controller
{
    public function index(): View
    {
        return view('wireguard.index');
    }
}
