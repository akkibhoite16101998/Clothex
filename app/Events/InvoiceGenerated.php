<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoiceDetails;

    public function __construct($invoiceDetails)
    {
        $this->invoiceDetails = $invoiceDetails;
    }
}
