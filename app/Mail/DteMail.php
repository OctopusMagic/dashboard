<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DteMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $receptor;
    protected $codGeneracion;
    protected $numeroControl;
    protected $selloRecibido;
    protected $fhProcesamiento;
    protected $estado;
    protected $pdfPath;
    protected $jsonPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $codGeneracion,
        $receptor,
        $numeroControl,
        $selloRecibido,
        $fhProcesamiento,
        $estado,
        $pdfPath,
        $jsonPath)
    {
        $this->codGeneracion = $codGeneracion;
        $this->receptor = $receptor;
        $this->numeroControl = $numeroControl;
        $this->selloRecibido = $selloRecibido;
        $this->fhProcesamiento = $fhProcesamiento;
        $this->estado = $estado;
        $this->pdfPath = $pdfPath;
        $this->jsonPath = $jsonPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Documento Tributario Electrónico')
            ->view('mail.dte')
            ->with([
                'codGeneracion' => $this->codGeneracion,
                'receptor' => $this->receptor,
                'numeroControl' => $this->numeroControl,
                'selloRecibido' => $this->selloRecibido,
                'fhProcesamiento' => $this->fhProcesamiento,
                'estado' => $this->estado,
            ])
            ->attach($this->pdfPath)
            ->attach($this->jsonPath);
    }
}
