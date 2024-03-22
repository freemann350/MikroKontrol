<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class BridgeController extends Controller
{
    public function index(): View
    {
        return view('bridges.index');
    }
}
