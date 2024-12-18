@extends('layout/main_wrapper')
@section('main')
<style>
    .red{
        color: red;
    }
</style>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-center">
                
                    <div class="bill-container p-4 border rounded">
                        <!-- Bill Header -->
                        <div class="bill-header d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
                            <div>
                                <img src="{{ asset('assets/images/logos/clothexlogo.jfif') }}" width="100" alt="Logo">
                            </div>
                            <div class="text-center text-md-end mt-3 mt-md-0">
                                <h5 class="mb-1">CLOTHEX MENS WEAR</h5>
                                <p class="mb-0">Dattanager Jambulwadi Road, Katraj</p>
                                <p class="mb-0">+91 9960466505</p>
                            </div>
                        </div>

                        <!-- Customer Details -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Name:</strong>{{ $data->name }}</p>
                                <p class="mb-1"><strong>Mobile:</strong>{{ $data->mobile }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                            @php
                                use Carbon\Carbon;
                                $bill_date = Carbon::parse($data->bill_date);
                                $today = Carbon::today();
                                $two_days_ago = $today->copy()->subDays(12);
                            @endphp
                                <p class="mb-1"><strong>Date:</strong>{{ \Carbon\Carbon::parse($data->bill_date)->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Bill No:</strong>{{  $data->id}}</p>
                            </div>
                        </div>
                        <form action="{{ route('bills.update_coustmer_bill',$data->id) }}" method="POST">
                        @csrf
                        <!-- Product Table -->
                        <div class="table-responsive mb-4">
                            
                                <table class="table table-bordered text-center">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Sr</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Amt</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $sr_no = 1;
                                        @endphp
                                        @foreach($data->purchases as $p)
                                        <tr data-id="{{ $p->id }}" class="item-row">
                                            <td>
                                            @if($bill_date->isToday() || $bill_date->greaterThanOrEqualTo($two_days_ago))
                                                <a href="javascript:void(0)" onclick="delete_purchases_item({{ $p->id }});">
                                                    <i class="ti ti-trash red"></i>
                                                </a>
                                            @endif
                                                {{ $sr_no++ }}
                                            </td>
                                            <td>
                                                <select name="product_name[]" class="form-control" required>
                                                    @foreach($product_list as $item)
                                                        <option value="{{ $item->id }}" @if($item->id == $p->product->id) selected @endif>
                                                            {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        
                                            <td>
                                                <input type="number" name="quantity[]" value="{{ $p->quantity ?? 0 }}" class="form-control quantity"  oninput="calculateTotal()" min="1" />
                                            </td>
                                            <td>
                                                <input type="number" name="price[]" value="{{ $p->price ?? 0 }}" class="form-control price" oninput="calculateTotal()" min="1" />
                                            </td>
                                            <td>
                                                <input type="number" name="total_amt[]" value="{{ $p->total_amt ?? 0 }}" class="form-control total" readonly  min="0"/>
                                            </td>

                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            
                        </div>

                        <!-- Footer Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <!--
                                <p class="mb-1"><strong>Discount (Amt):</strong>{{ $data->payment->disc_amt }}</p>
                                <p class="mb-1"><strong>Discount (%):</strong>{{ $data->payment->disc_percentage }}</p>-->
                                <input type="hidden" name="disc_percentage" id="disc_percentage" value="{{ $data->payment->disc_percentage ?? 0 }}" class="form-control"   min="0" />
                                <input type="hidden" name="received_amount" id="received_amount" value="{{ $data->payment->total_paid_amt ?? 0 }}" class="form-control"   min="0" />

                            </div>
                            <div class="col-md-6 text-md-end">
                                <p class="mb-1" id="grand-total"><strong>Grand Total Amt:</strong> {{ $data->payment->grand_total }}</p>
                                <p class="mb-1" id="disc-amt"><strong>Discount Amt:</strong> {{ $data->payment->disc_amt }}</p>
                                <p class="mb-1" id="total-paid-amt"><strong>Total Amt:</strong> {{ $data->payment->total_paid_amt }}</p>
                            </div>
                        </div>
                        <button type="submit" name="edit_btn" id="edit_btn" class="btn btn-dark">Update</button>

                        </form>
                    </div>
                
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    function delete_purchases_item(id) {
        var delete_id = "";

        if (id != "" && id > 0 && !isNaN(id)) {
            delete_id = id;

            var confirmDelete = window.confirm("Are you sure you want to delete this item?");
            
            if (confirmDelete) {

                var reason = prompt("Please provide a reason for deleting this item:");
                
                if (reason && reason.trim() !== "")
                {
                    $.ajax({
                        url: "{{ route('bills.delete_item') }}",  
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",  
                            "purchases_id": delete_id, 
                            "reason": reason  
                        },
                        
                        success: function(response) 
                        {
                            if (response.success) 
                            {
                                // Update the HTML with the new values from the response
                                $('#grand-total').html('<b>Grand Total Amt:</b> ' + response.update_grand_total);
                                $('#disc-amt').html('<b>Discount Amt:</b> ' + response.update_disc_amt);
                                $('#total-paid-amt').html('<b>Total Amt:</b> ' + response.update_total_paid_amt);

                                $('tr[data-id="' + id + '"]').remove();

                                // Optionally, show a success message
                                alert(response.message);
                                alert('Refund Amount is: ' + response.refundAmt);
                                $("#received_amount").val(response.update_total_paid_amt);

                            } else {
                                alert(response.message);  // Show failure message
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle any errors here
                            alert('An error occurred. Please try again.');
                        }

                    });
                } else {
                    alert("Reason is required for deletion.");
                }
            } else {
                alert("Item deletion canceled.");
            }
        } else {
            alert("Invalid ID.");
        }
    }
</script>

<script>
    function calculateTotal() 
    {
        let discPercentage = parseFloat(document.getElementById("disc_percentage").value) || 0; 
        const rows = document.querySelectorAll(".item-row");
        let grandTotal = 0;

        const total_paid_amt = $("#received_amount").val();
        //alert(total_paid_amt);

        rows.forEach(row => {
            const price = parseFloat(row.querySelector(".price").value) || 0;
            const quantity = parseFloat(row.querySelector(".quantity").value) || 0;
            const total = price * quantity;

            row.querySelector(".total").value = total.toFixed(2);

            grandTotal += total;
        });

        const discountAmt = (discPercentage > 0) ? Math.ceil((grandTotal * discPercentage) / 100) : 0;

        const paidAmount = grandTotal - discountAmt;

        if (total_paid_amt > paidAmount) 
        {
            const returnAmount = total_paid_amt - paidAmount;
            alert(`Return Amount: ₹${returnAmount.toFixed(2)}`);
        } else if (total_paid_amt < paidAmount) 
        {
            const getAmount = paidAmount - total_paid_amt;
            alert(`Get Amount: ₹${getAmount.toFixed(2)}`);
        } 

        document.getElementById("disc-amt").innerHTML = `<b>Discount Amt:</b> ₹${discountAmt}`;
        document.getElementById("grand-total").innerHTML = `<b>Grand Total Amt:</b> ₹${grandTotal.toFixed(2)}`;
        document.getElementById("total-paid-amt").innerHTML = `<b>Total Amt:</b> ₹${paidAmount.toFixed(2)}`;
    }

</script>

