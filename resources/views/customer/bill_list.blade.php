@extends('layout.main_wrapper')
@section('main')
<div class="container">
    <h1 class="mb-4">hello</h1>
</div>
    @if (Session::has('success'))
    <div class="col-md-12 mt-4">
        <div class="alert alert-success">
        {{ Session::get('success')}}
        </div>
    </div>
    @endif
    @if (Session::has('error'))
    <div class="col-md-12 mt-4">
        <div class="alert alert-danger">
        {{ Session::get('error')}}
        </div>
    </div>
    @endif
    <div class="container mt-5">
        <div class="row justify-content-center" style="margin-bottom: 20px;">
            <form method="GET" action="{{ route('customer.customerlist') }}" name="bill_form" id="bill_form" class="row g-3">
            <div class="col-md-3">
                <h5 class="mb-4">Customer List</h5>
            </div>
            <div class="col-md-2">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $start_date }}">
                </div>
                <div class="col-md-2">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $end_date }}">
                </div>
                <div class="col-md-2" style="margin-top: 45px;">
                    <button type="submit" name="filter" class="btn btn-primary w-100">Submit</button>
                </div>
                <div class="col-md-2" style="margin-top: 40px;">
                    <a href=" {{ route('customer.bill') }}" class="btn btn-dark m-1">Create Bill</a>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name || mobile</th>
                <th>Date</th>
                <th>Discount || Paid Amount</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $customer_list as $key => $rec)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $rec->name }} <br> {{ $rec->mobile }}</td>
                <td>{{ \Carbon\Carbon::parse($rec->bill_date)->format('d/m/Y') }}</td>
                <td><span class="badge bg-success">{{ $rec->payment->disc_amt ?? 0 }}</span> &nbsp;|| <span class="badge bg-dark">{{ $rec->payment->total_paid_amt ?? 0}}</span></td>
                <td><span class="badge bg-primary">{{ $rec->payment->grand_total ?? 0 }}</span></td>
                <td><!-- View Button -->
                    <a href="{{ route('customer.viewBill',['action' => 'view', 'id' => $rec->id]) }}" class="btn btn-primary" title="View"><i class="ti ti-eye"></i> </a>
                    <!-- Edit Button -->
                    <a href="{{ route('customer.viewBill',['action' => 'edit', 'id' => $rec->id])  }}" class="btn btn-warning text-white" title="Edit"><i class="ti ti-edit"></i> </a>
                    <!-- Delete Button -->
                    <form action="{{ route('customer.bill_delete',$rec->id) }}" method="post"> @csrf
                        <button type="submit" class="btn btn-danger" title="Delete"><i class="ti ti-trash"></i> </button>
                    </form>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $customer_list->links() }}
    </div>
</div>
@endsection