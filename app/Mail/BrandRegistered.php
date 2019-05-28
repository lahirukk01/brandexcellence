<?php

namespace App\Mail;

use App\Brand;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BrandRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $brand;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.brand_registered');
    }
}
