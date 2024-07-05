<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $statistics = Http::get('http://localhost:8000/dtes/statistics/')->json();
        $datos_empresa = Http::get('http://localhost:8000/datos_empresa/1')->json();
        return view('home', compact('statistics', 'datos_empresa'));
    }
}
