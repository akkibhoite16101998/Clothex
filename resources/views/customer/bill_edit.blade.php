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
                                <p class="mb-1"><strong>Date:</strong>{{ \Carbon\Carbon::parse($data->bill_date)->format('d/m/Y') }}</p>
                                <p class="mb-1"><strong>Bill No:</strong>{{  $data->id}}</p>
                            </div>
                        </div>

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
                                    <tr>
                                        <td><a href="javascript:void(0)"  onclick="delete_purchases_item({{ $p->id }});" ><i class="ti ti-trash red"></i></a>
                                            {{ $sr_no++ }}
                                        </td>
                                        <td>{{ $p->product->name ?? 'N/A' }}</td> 
                                        <td>{{ $p->quantity ?? '0' }}</td>
                                        <td>{{ $p->price ?? '0' }}</td>
                                        <td>{{ $p->total_amt ?? '0' }}</td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Details -->
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Discount (Amt):</strong>{{ $data->payment->disc_amt }}</p>
                                <p class="mb-1"><strong>Discount (%):</strong>{{ $data->payment->disc_percentage }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p class="mb-1" id="grand-total"><strong>Grand Total Amt:</strong> {{ $data->payment->grand_total }}</p>
                                <p class="mb-1" id="disc-amt"><strong>Discount Amt:</strong> {{ $data->payment->disc_amt }}</p>
                                <p class="mb-1" id="total-paid-amt"><strong>Total Amt:</strong> {{ $data->payment->total_paid_amt }}</p>
                            </div>
                        </div>
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
                                $('#grand-total').text(response.update_grand_total);
                                $('#disc-amt').text(response.update_disc_amt);
                                $('#total-paid-amt').text(response.update_total_paid_amt);

                                // Optionally, show a success message
                                alert(response.message);
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
