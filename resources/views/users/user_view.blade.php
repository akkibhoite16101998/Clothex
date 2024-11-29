@extends('layout.main_wrapper')
@section('main')
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-8">
                        <h2 class="mb-4">User Information</h2>
                    </div>
                    <div class="col-md-4">
                        <a href=" {{ route('users.userslist') }}" class="btn btn-dark m-1" title="User List" >User List</a> 
                        <a href="{{ route('user.view', ['edit', $data->id]) }}" class="btn btn-dark m-1" title="User Edit" >User Edit</a>
                    </div>
                </div>
                <div class="card">
                  <div class="card-body">
                      <div class="mb-3">
                        <label for="name" class="form-label">User Name</label>
                        <input type="text"  value="{{ $data->name }}" class="form-control" readonly>
                      
                      </div>
                      <div class="mb-3">
                        <label for="name" class="form-label">Email</label>
                        <input type="text"  value="{{ $data->email }}" class="form-control" readonly>
                        
                      </div>
                      <!--<div class="mb-3">
                        <label for="name" class="form-label">Password</label>
                        <input type="number"  value="{{ $data->password }}" class="form-control" >
                      </div>-->
                      <div class="mb-3">
                        <label for="name" class="form-label">Role</label>
                        <select name="user_role" id="user_role" class="form-control" disabled>
                          <option value="staff" {{ old('user_role', $data->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                          <option value="admin" {{ old('user_role', $data->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                      </div>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                  </div>
                </div>
            </div>
          </div>
        </div>
@endsection
