<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KonfirmasiPembatalanSesiPkp extends Mailable
{
    use Queueable, SerializesModels;
public $sesi;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sesi)
    {
         $this->sesi = $sesi;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Konfirmasi Pembatalan Sesi Peminjaman Perlengkapan')
                    ->view('emails.konfirmasi_pembatalan_sesi_pkp');
    }
}
