<?php

namespace App\Models\Billing;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    public function customer()
    {
        return $this->belongsTo(CustomerDetail::class, 'c_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_name', 'id');
    }


}
