<?php

namespace App\Http\Controllers;

use App\Mail\DteMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class MailController extends Controller
{
    public function mandar_correo(Request $request)
    {
        $request->validate([
            'codGeneracion' => 'required|string',
            'correo' => 'required|email',
        ]);

        $codGeneracion = $request->input('codGeneracion');
        $correo = $request->input('correo');

        $pdfPath = public_path("storage/dtes/{$codGeneracion}/{$codGeneracion}.pdf");
        $jsonPath = public_path("storage/dtes/{$codGeneracion}/{$codGeneracion}.json");

        if (!file_exists($pdfPath) || !file_exists($jsonPath)) {
            return response()->json(['error' => 'Files not found'], 404);
        }

        Mail::to($correo)->send(new DteMail($codGeneracion, $pdfPath, $jsonPath));

        return redirect()->route('invoices.index')->with('success', 'Correo enviado');
    }
}
