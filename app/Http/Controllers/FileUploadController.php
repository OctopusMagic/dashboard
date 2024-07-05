<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class FileUploadController extends Controller
{
    public function uploadFiles(Request $request)
    {
        Log::info('Request received', $request->all());

        // Validar la solicitud
        $validator = Validator::make($request->all(), [
            'codGen' => 'required|string',
            'pdf' => 'required|file|mimes:pdf',
            'json' => 'required|file|mimes:json',
            'ticket' => 'nullable|file|mimes:pdf',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $codGen = $request->input('codGen');
        $directory = "public/dtes/{$codGen}";

        // Crear el directorio si no existe
        Storage::makeDirectory($directory);

        // Verificar y almacenar el archivo PDF
        if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
            $pdfFile = $request->file('pdf');
            Storage::put("{$directory}/{$codGen}.pdf", file_get_contents($pdfFile));
            $pdfPath = "{$directory}/{$codGen}.pdf";
        } else {
            Log::error('PDF file is invalid or not present');
            return response()->json(['error' => 'PDF file is invalid or not present'], 400);
        }

        // Verificar y almacenar el archivo JSON
        if ($request->hasFile('json') && $request->file('json')->isValid()) {
            $jsonFile = $request->file('json');
            Storage::put("{$directory}/{$codGen}.json", file_get_contents($jsonFile));
            $jsonPath = "{$directory}/{$codGen}.json";
        } else {
            Log::error('JSON file is invalid or not present');
            return response()->json(['error' => 'JSON file is invalid or not present'], 400);
        }

        // Verificar y almacenar el archivo de ticket si está presente
        $ticketPath = null;
        if ($request->hasFile('ticket') && $request->file('ticket')->isValid()) {
            $ticketFile = $request->file('ticket');
            Storage::put("{$directory}/{$codGen}_ticket.pdf", file_get_contents($ticketFile));
            $ticketPath = "{$directory}/{$codGen}_ticket.pdf";
        }

        return response()->json([
            'pdfPath' => url(Storage::url($pdfPath)),
            'jsonPath' => url(Storage::url($jsonPath)),
            'ticketPath' => $ticketPath ? url(Storage::url($ticketPath)) : null
        ]);
    }
}



