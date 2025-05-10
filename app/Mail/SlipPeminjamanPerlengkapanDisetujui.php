<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SlipPeminjamanPerlengkapanDisetujui extends Mailable
{
    public $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function build()
    {
        return $this->subject('Slip Peminjaman Perlengkapan Anda Disetujui')
        ->view('emails.slip_peminjaman_perlengkapan_disetujui');
    }
}
