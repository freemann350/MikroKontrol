<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DnsController extends Controller
{
    public function index(): View
    {
        return view('dns.index');
    }
}
