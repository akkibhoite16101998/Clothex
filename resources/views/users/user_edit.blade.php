@extends('layout.main_wrapper')
@section('main')
<div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
            <div class="row">
                        <div class="col-md-10">
                        <h2 class="mb-4">Edit Users Details</h2>
                    </div>
                    <div class="col-md-2">
                        <a href=" {{ route('users.userslist') }}" class="btn btn-dark m-1" title="User List" >User List</a> 
                    </div>
              <div class="card">
                <div class="card-body">
                  <form action="{{ route('users.update_user',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="name" class="form-label">User Name</label>
                      <input type="text"  value="{{ old('user_name', $data->name) }}" class="form-control @error('user_name') is-invalid  @enderror " id="user_name" name="user_name">
                      @error('user_name')
                      <p class="invalid-feedback"> {{ $message }}</p>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">Email</label>
                      <input type="text"  value="{{ old('user_eamil', $data->email) }}" class="form-control @error('user_eamil') is-invalid  @enderror" id="user_eamil" name="user_eamil">
                      @error('user_eamil')
                      <p class="invalid-feedback"> {{ $message }}</p>
                      @enderror
                    </div>
                    <!--
                    <div class="mb-3">
                      <label for="name" class="form-label">Password</label>
                      <input type="number"  value="{{ old('password') }}" class="form-control @error('password') is-invalid  @enderror" id="password" name="password" min="0">
                      @error('password')
                      <p class="invalid-feedback"> {{ $message }}</p>
                      @enderror
                    </div>-->
                    <div class="mb-3">
                      <label for="name" class="form-label">Role</label>
                      <select name="user_role" id="user_role" class="form-control">
                        <option value="staff" {{ old('user_role', $data->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ old('user_role', $data->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
