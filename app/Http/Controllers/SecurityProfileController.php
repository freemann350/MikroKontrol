<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class SecurityProfileController extends Controller
{
    public function index(): View
    {
        return view('security_profiles.index');
    }
}
