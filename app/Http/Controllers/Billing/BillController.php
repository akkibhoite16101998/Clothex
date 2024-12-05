<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\Billing\CustomerDetail;
use App\Models\Billing\PaymentDetails;
use App\Models\Billing\PurchaseDetails;
use App\Models\Billing\CustomerPurchaseDeletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class BillController extends Controller
{

    //Insert coustmer bill code
    public function create_coustmer_bill(Request $request)
    {
        $customer_details = new CustomerDetail();
        $customer_details->name = $request->coustmer_name;
        $customer_details->mobile = $request->mobile_no;
        $customer_details->bill_date = $request->bill_date;
        $customer_details->save();
    
        if (!empty($request->coustmer_name) && $customer_details->id) 
        {
            $product_type_arr = $request->product_type;
            $quantity_arr = $request->quantity;
            $price_arr = $request->price;
            $total_amt_arr = $request->total;
    
            foreach ($product_type_arr as $key => $product_id) 
            {
                $purchase_details = new PurchaseDetails();
                $purchase_details->product_name = $product_id;
                $purchase_details->quantity = $quantity_arr[$key];
                $purchase_details->price = $price_arr[$key];
                $purchase_details->total_amt = $total_amt_arr[$key];
                $purchase_details->c_id = $customer_details->id;
                $purchase_details->save();
            }
    
            $payment_details = new PaymentDetails();
            $payment_details->payment_mode = $request->payment_mode;
            $payment_details->disc_percentage = $request->discount_percentage;
            $payment_details->disc_amt = $request->discount_amt;
            $payment_details->grand_total = $request->grand_total_amt;
            $payment_details->total_paid_amt = $request->total_pay_amt;
            $payment_details->c_id = $customer_details->id;
            $payment_details->save();
    
            if ($payment_details->id) {
                return redirect()->route('customer.bill')->with('success', 'Bill Generated Successfully!');
            }
        } else {
            return redirect()->route('customer.bill')->with('error', 'Something Went Wrong!');
        }
    }

    public function getCustomerWithDetails(Request $request)
    {
        $current_date = date('Y-m-d');
        $start_date = $request->input('start_date', $current_date);
        $end_date = $request->input('end_date', $current_date);

        $customers = CustomerDetail::with(['purchases.product', 'payment'])
                    ->whereDate('bill_date', '>=', $start_date)
                    ->whereDate('bill_date', '<=', $end_date)
                    ->get();

        #echo"<pre>";print_r($customers->toArray());die();

        return view('customer/all_coutmers_bills', [
            'bills' => $customers,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    
    public function create_bill(){

        $product_list = DB::table('products')->get();
        # "<pre>";print_r($product_list);die();
        return view('customer.create_bill',['product_type'=>$product_list]);
    }

    public function customerlist(Request $request)
    {
        $current_date = date('Y-m-d');
        $start_date = $request->input('start_date', $current_date);
        $end_date = $request->input('end_date', $current_date);
    
        $customer_list = CustomerDetail::with('payment:total_paid_amt,disc_amt,grand_total,c_id')
            ->select(['id', 'name', 'mobile', 'bill_date'])
            ->whereBetween('bill_date', [$start_date, $end_date])
            ->orderBy('id','DESC')
            ->paginate(2)
            ->appends([
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
    
        return view('customer.bill_list', [
            'customer_list' => $customer_list,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ]);
    }

    public function viewBill($action, $id){

        #$customer = CustomerDetail::find($id);
        $customer = CustomerDetail::with(['purchases.product', 'payment'])
                     ->findOrFail($id);


        switch ($action) {
            case 'view':
                return view('customer.bill_view', ['data'=>$customer]);
                
            case 'edit':
                return view('customer.bill_edit', ['data'=>$customer]);
            default:
                abort(404); 
        }

    }

    #this function use to delete coustomer item 
    public function DeleteCustomerItem(Request $request)
    {
        $payment_auto_id = "";
        $purchases_id = $request->input('purchases_id');
        $reason = $request->input('reason');

        $purchases = PurchaseDetails::with('payment_details')->find($purchases_id);
        
        if (!$purchases) {
            return response()->json(['error' => 'Purchase not found'], 404);
        }

        $payment_auto_id = $purchases->payment_details->id;
        $customer_id = $purchases->c_id;
        $product_id = $purchases->product_name; // Stored here id not name
        $product_quantity = $purchases->quantity;
        $product_price  = $purchases->price;
        $disc_percentage  = $purchases->disc_percentage;
        $user_id = Auth::id();

        $update_grand_total = $purchases->payment_details->grand_total - $purchases->total_amt;
        $item_discount = ($purchases->total_amt * $purchases->payment_details->disc_percentage) / 100;
        $update_disc_amt = $purchases->payment_details->disc_amt - $item_discount;
        $update_total_paid_amt = $purchases->payment_details?->total_paid_amt ?? 0 - $purchases->total_amt + $item_discount;
        
        if ($payment_auto_id != "" && is_numeric($payment_auto_id)) {
            $payment_arr = PaymentDetails::find($payment_auto_id);

            if (!$payment_arr) {
                return response()->json(['error' => 'Payment details not found'], 404);
            }

            $payment_arr->grand_total = $update_grand_total;
            $payment_arr->disc_amt = $update_disc_amt;
            $payment_arr->total_paid_amt = $update_total_paid_amt;
            $up_rec = $payment_arr->save();

            if ($up_rec) 
            {
                $purchaseDeletion = new CustomerPurchaseDeletion();
                $purchaseDeletion->c_id = $customer_id;
                $purchaseDeletion->product_id  = $product_id;
                $purchaseDeletion->quantity = $product_quantity;
                $purchaseDeletion->product_price = $product_price;
                $purchaseDeletion->disc_percentage = $disc_percentage;
                $purchaseDeletion->deleted_by = $user_id;
                $purchaseDeletion->reason = $reason;
                $add_rec = $purchaseDeletion->save();

                if ($add_rec) 
                {
                    if ($purchases->delete()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Item deleted successfully.',
                            'update_grand_total' => $update_grand_total,
                            'update_disc_amt' => $update_disc_amt,
                            'update_total_paid_amt' => $update_total_paid_amt
                        ]);
                    } else {
                        return response()->json(['error' => 'Failed to delete purchase details'], 500);
                    }
                } else {
                    return response()->json(['error' => 'Failed to record deletion in history'], 500);
                }
            } else {
                return response()->json(['error' => 'Failed to update payment details'], 500);
            }
        }
    }

    
}
