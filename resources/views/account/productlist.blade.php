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
    <div class="row">
        <div class="col-md-10">
        <h2 class="mb-4">Product List</h2>
    </div>
    <div class="col-md-2">
        <a href=" {{ route('account.add_product') }}" class="btn btn-dark m-1">Add Product</a>
    </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>SKU No</th>
                <th>Price</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $data as $key => $rec)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $rec->name }}</td>
                <td>{{ $rec->sku_id }}</td>
                <td>{{ $rec->price}}</td>
                <td>{{ $rec->image}}</td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-3">
        {{ $data->links() }}
    </div>
</div>
@endsection