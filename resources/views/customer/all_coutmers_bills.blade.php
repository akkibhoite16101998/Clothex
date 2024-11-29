@extends('layout.main_wrapper')
@section('main')
<style>
        body {
            font-size: 0.9rem; 
        }
        .bill-container {
            max-width: 400px; 
            border: 1px solid #ccc;
            padding: 10px;
            background: #f8f9fa;
            margin-bottom: 15px;
        }
        .bill-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .bill-header img {
            max-height: 100px; 
            border-radius: 50%;
        }
        .bill-footer {
            margin-top: 10px;
            font-size: 0.85rem; 
        }
        table {
            font-size: 0.85rem; 
        }
    </style>
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="container">
                <div class="row justify-content-center">
                    <form method="GET" action="{{ route('bills.getCustomerWithDetails') }}" name="bill_form" id="bill_form" class="row g-3">
                        <div class="col-md-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="filter" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
                <!--Bill genrate code Start -->
                    <div class="container my-3">
                        <!-- Responsive Row for Two Bills -->
                        <div class="row">
                            <!-- Bill 1 -->

                            @foreach($bills as $b)
                            <div class="col-md-6">
                                <div class="bill-container">
                                    <!-- Bill Header -->
                                    <div class="bill-header">
                                        <div>
                                            <img src="{{ asset('assets/images/logos/clothexlogo.jfif') }}"  width="100" alt="Logo">
                                        </div>
                                        <div>
                                            <h5 class="mb-0">CLOTHEX MENS WEAR</h5>
                                            <p class="mb-0">Dattanager Jambulwadi Road Katraj</p>
                                            <p class="mb-0">+91 9960466505</p>
                                        </div>
                                    </div>

                                    <!-- Customer Details -->
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <p class="mb-1"><strong>Name:</strong>{{ $b->name }}</p>
                                            <p class="mb-1"><strong>Mobile:</strong>{{ $b->mobile }}</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($b->bill_date)->format('d/m/Y') }}</p>
                                            <p class="mb-1"><strong>Bill No:</strong>{{ $b->id }}</p>
                                        </div>
                                    </div>

                                    <!-- Product Table -->
                                    <table class="table table-bordered">
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
                                            <!-- Sample Row -->
                                             @php 
                                                $sr_no = 1;
                                             @endphp
                                            @foreach($b->purchases as $pr)
                                            
                                            <tr>
                                                <td>{{ $sr_no ++}}</td>
                                                <td>{{ $pr->product->name ?? 'N/A' }}</td> 
                                                <td>{{ $pr->quantity}}</td>
                                                <td>{{ $pr->price}}</td>
                                                <td>{{ $pr->total_amt}}</td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>

                                    <!-- Footer Details -->
                                    <div class="row bill-footer">
                                        <div class="col-6">
                                            <p class="mb-1"><strong>Discount (Amt):</strong>{{ $b->payment->disc_amt}}</p>
                                            <p class="mb-1"><strong>Discount (%):</strong>{{$b->payment->disc_percentage }}</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p class="mb-1"><strong>Grand Total Amt:</strong>{{ $b->payment->grand_total}}</p>
                                            <p class="mb-1"><strong>Discount Amt:</strong>{{ $b->payment->disc_amt }}</p>
                                            <p class="mb-1"><strong>Total Amt:</strong>{{ $b->payment->total_paid_amt }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach



                        </div>
                    </div>
                <!--End -->
            </div>
        </div>
    </div>
</div>

@endsection