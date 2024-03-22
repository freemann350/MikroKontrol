<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use Illuminate\Http\Request;

class InterfacesController extends Controller
{
    public function index(): View
    {
        return view('interfaces.index');
    }
}
