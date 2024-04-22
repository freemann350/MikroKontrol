<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(): View
    {
        return view('dashboard.index');
    }
    
    public function indexDevice($device): View
    {
        return view('dashboard.indexDevice');
    }
}
