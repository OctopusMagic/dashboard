<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


class InvoicesController extends Controller
{
    public function index()
    {
        if(request()->has('fecha')){
            $response = Http::get('http://localhost:8000/dtes/?fecha_inicio=' . request('fecha') . ' 00:00:00&fecha_fin=' . request('fecha'). ' 23:59:59');
            $statistics = Http::get('http://localhost:8000/dtes/statistics/?fecha=' . request('fecha'));
        } else {
            $response = Http::get('http://localhost:8000/dtes/');
            $statistics = Http::get('http://localhost:8000/dtes/statistics/');
        }
        $dtes = $response->json();

        // Check query params to filter invoices
        if (request()->has('type')) {
            $dtes = array_filter($dtes, function ($dte) {
                return $dte['estado'] == request('type');
            });
        }

        $dtes = array_map(function ($dte) {
            $dte['documento'] = json_decode($dte["documento"]);
            return $dte;
        }, $dtes);

        return view('invoices', ['invoices' => $dtes, 'fecha' => request('fecha'), 'statistics' => $statistics->json()]);
    }

    public function download_dtes()
    {
        $response = Http::get('http://localhost:8000/dtes/');
        $dtes = $response->json();

        
    }

    public function compile_dtes()
    {
        return view('download');
    }
}