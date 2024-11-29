<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    public function customer()
    {
        return $this->belongsTo(CustomerDetail::class, 'c_id', 'id');
    }

}
