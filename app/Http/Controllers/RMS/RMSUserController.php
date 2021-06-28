<?php

namespace App\Http\Controllers\RMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RMSUserController extends Controller
{
    public function index()
    {
        return view('rms.users.index');
    }
}
