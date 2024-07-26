<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

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

    public function compileAndDownload(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        // Realizar la solicitud al backend para obtener los datos
        $response = Http::get("http://localhost:8000/dtes/?fecha_inicio={$fecha_inicio}&fecha_fin={$fecha_fin}");
        $dtes = $response->json();

        // Convertir las fechas al formato ddmmyy
        $fecha_inicio_formateada = \DateTime::createFromFormat('Y-m-d\TH:i', $fecha_inicio)->format('dmY');
        $fecha_fin_formateada = \DateTime::createFromFormat('Y-m-d\TH:i', $fecha_fin)->format('dmY');

        // Crear y abrir el archivo ZIP
        $zip = new \ZipArchive();
        $zipFileName = "dtes_{$fecha_inicio_formateada}_{$fecha_fin_formateada}.zip";
        $zipFilePath = storage_path("app/public/{$zipFileName}");

        if ($zip->open($zipFilePath, \ZipArchive::CREATE) === TRUE) {
            // Recorrer los DTEs y agregar archivos al ZIP
            foreach ($dtes as $dte) {
                $codGeneracion = $dte['codGeneracion'];
                $fhProcesamiento = $dte['fhProcesamiento'];
                $fechaProcesamiento = (new \DateTime($fhProcesamiento))->format('Y-m-d');
                $directory = 'public/dtes/' . $codGeneracion;

                // URLs de los archivos
                $files = [
                    "{$directory}/{$codGeneracion}.pdf",
                    "{$directory}/{$codGeneracion}.json",
                ];

                // Verificar la existencia del ticket
                $ticketFile = "{$directory}/{$codGeneracion}_ticket.pdf";
                if (Storage::exists($ticketFile)) {
                    $files[] = $ticketFile;
                }

                // Agregar los archivos al ZIP
                foreach ($files as $file) {
                    if (Storage::exists($file)) {
                        $zip->addFile(Storage::path($file), "{$fechaProcesamiento}/{$codGeneracion}/" . basename($file));
                    }
                }
            }

            // Cerrar el archivo ZIP
            $zip->close();

            // Descargar el archivo ZIP
            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'No se pudo crear el archivo ZIP'], 500);
        }
    }


}
