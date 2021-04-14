<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendmail extends Mailable
{
    use Queueable, SerializesModels;
    public $hse;
    public $subject;
    public $view;
    public $pdf;
    public $pdfname;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$data,$view,$pdf,$pdfname)
    {
        $this->hse = $data;
        $this->subject = $subject;
        $this->view = $view;
        $this->pdf = $pdf;
        $this->pdfname = $pdfname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view($this->view)
        ->attachData($this->pdf->output(), $this->pdfname, [
            'mime' => 'application/pdf',
        ]);
    }
}
