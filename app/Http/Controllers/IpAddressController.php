<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class IpAddressController extends Controller
{
    public function index(): View
    {
        return view('ip_addresses.index');
    }
}
