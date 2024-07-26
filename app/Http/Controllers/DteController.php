<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DteController extends Controller
{
    public function downloadAndStoreDte()
    {
        $response = Http::get('http://localhost:8000/dtes/');
        $dtes = $response->json();

        foreach ($dtes as $dte) {
            $codGeneracion = $dte['codGeneracion'];
            $directory = 'public/dtes/' . $codGeneracion;

            // Crear directorio si no existe
            Storage::makeDirectory($directory);

            // URLs de los archivos
            $files = [
                "{$directory}/{$codGeneracion}.pdf" => "https://dtes-puma.s3.amazonaws.com/01/{$codGeneracion}.pdf",
                "{$directory}/{$codGeneracion}.json" => "https://dtes-puma.s3.amazonaws.com/01/{$codGeneracion}.json",
            ];

            // Verificar la existencia del ticket
            $ticketUrl = "https://dtes-puma.s3.amazonaws.com/01/{$codGeneracion}_ticket.pdf";
            if ($this->urlExists($ticketUrl)) {
                $files["{$directory}/{$codGeneracion}_ticket.pdf"] = $ticketUrl;
            }

            foreach ($files as $filePath => $url) {
                if ($this->urlExists($url)) {
                    try {
                        $content = file_get_contents($url);
                        Storage::put($filePath, $content);
                    } catch (\Exception $e) {
                        // Manejar la excepción o registrar el error
                        \Log::error("Error downloading file from {$url}: " . $e->getMessage());
                    }
                } else {
                    \Log::warning("File not found at {$url}");
                }
            }
        }

        return response()->json(['message' => 'DTEs downloaded and stored successfully']);
    }

    private function urlExists($url)
    {
        $headers = get_headers($url, 1);
        return strpos($headers[0], '200') !== false;
    }

    public function sendContingencia()
    {
        $response = Http::post("http://localhost:8000/contingencia/auto");
        return $response->json();
    }
}
