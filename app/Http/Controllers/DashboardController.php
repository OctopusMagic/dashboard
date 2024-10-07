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
        $today = date('Y-m-d');
        $statistics = Http::get('http://localhost:8000/dtes/statistics/')->json();
        $statistics_today = Http::get("http://localhost:8000/dtes/statistics/?fecha=$today")->json();
        $datos_empresa = Http::get('http://localhost:8000/datos_empresa/1')->json();

        $contingencia = Http::get('http://localhost:8000/contingencia/estado')->json();
        $contingencia = $contingencia['message'];

        return view('home', compact('statistics', 'datos_empresa', 'statistics_today', 'contingencia'));
    }
}
