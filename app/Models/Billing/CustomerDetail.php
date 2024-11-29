<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class CustomerDetail extends Model
{
    public function purchases()
    {
        return $this->hasMany(PurchaseDetails::class, 'c_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentDetails::class, 'c_id', 'id');
    }

}
