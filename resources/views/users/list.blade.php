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
        <h2 class="mb-4">User List</h2>
    </div>
    <div class="col-md-2">
        <a href=" {{ route('user.add_user') }}" class="btn btn-dark m-1">Add New User</a>
    </div>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $users_list as $key => $rec)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $rec->name }}</td>
                <td>{{ $rec->email }}</td>
                <td>{{ $rec->role}}</td>
                <td><!-- View Button -->
                    <a href="{{ route('user.view',['action' => 'view', 'id' => $rec->id]) }}" class="btn btn-primary" title="View"><i class="ti ti-eye"></i> </a>
                    <!-- Edit Button -->
                    <a href="{{ route('user.view',['action' => 'edit', 'id' => $rec->id])  }}" class="btn btn-warning text-white" title="Edit"><i class="ti ti-edit"></i> </a>
                    <!-- Delete Button -->
                    <form action="{{ route('user.destroy',$rec->id) }}" method="post"> @csrf
                        <button type="submit" class="btn btn-danger" title="Delete"><i class="ti ti-trash"></i> </button>
                    </form>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>
@endsection