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

    protected $codGeneracion;
    protected $pdfPath;
    protected $jsonPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codGeneracion, $pdfPath, $jsonPath)
    {
        $this->codGeneracion = $codGeneracion;
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
        return $this->subject('Facturación Electrónica')
            ->view('mail.dte')
            ->with([
                'codGeneracion' => $this->codGeneracion,
            ])
            ->attach($this->pdfPath)
            ->attach($this->jsonPath);
    }
}
