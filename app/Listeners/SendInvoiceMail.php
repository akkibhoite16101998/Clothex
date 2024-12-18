<?php

namespace App\Listeners;

use App\Events\InvoiceGenerated;
use Illuminate\Support\Facades\Mail;
use PDF;

class SendInvoiceMail
{   
    public function handle(InvoiceGenerated $event)
    {
        $invoiceDetails = $event->invoiceDetails;

        // Generate PDF
        $pdf = PDF::loadView('invoice.billInvoice', ['data' => $invoiceDetails['data']]);

        // Send Mail
        Mail::send([], [], function ($message) use ($invoiceDetails, $pdf) {
            $customerName = $invoiceDetails['name']; 

            $message->to($invoiceDetails['email'])
                    ->subject('Your Invoice from Clothex')
                    ->html("
                        <p>Dear $customerName,</p>
                        <p>Thank you for visiting Clothex. We hope you had a great experience shopping with us.</p>
                        <p>Please find your invoice attached for your reference.</p>
                        <p>Best regards,<br>Clothex Team</p>
                    ")
                    ->attachData($pdf->output(), 'invoice.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        });
    }


}
