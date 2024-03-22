<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class StaticRouteController extends Controller
{
    public function index(): View
    {
        return view('static_routes.index');
    }
}
