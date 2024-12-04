@extends('layout/main_wrapper')
@section('main')
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
                                        <td>{{ $sr_no++ }}</td>
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
                                <p class="mb-1"><strong>Grand Total Amt:</strong> {{ $data->payment->grand_total }}</p>
                                <p class="mb-1"><strong>Discount Amt:</strong> {{ $data->payment->disc_amt }}</p>
                                <p class="mb-1"><strong>Total Amt:</strong> {{ $data->payment->total_paid_amt }}</p>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
</div>

@endsection