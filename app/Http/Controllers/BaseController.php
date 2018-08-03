<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ckfinder_getConnector()
    {
        require_once public_path('assets\ckfinder\core\connector\php\connector.php');
    }

    public function getCkfinderView()
    {
        return view('layouts.ckfinder_view');
    }
}
