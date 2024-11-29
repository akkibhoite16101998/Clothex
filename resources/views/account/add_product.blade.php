@extends('layout.main_wrapper')
@section('main')
<div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Add Products Details</h5>
              <div class="card">
                <div class="card-body">
                  <form action="{{ route('procduct.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label for="name" class="form-label">Product Name</label>
                      <input type="text" value="{{ old('product_name') }}" class="form-control @error('product_name') is-invalid  @enderror " id="product_name" name="product_name">
                      @error('product_name')
                      <p class="invalid-feedback"> {{ $message }}</p>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">SKU No</label>
                      <input type="text" value="{{ old('sku_id') }}" class="form-control @error('sku_id') is-invalid  @enderror" id="sku_id" name="sku_id">
                      @error('sku_id')
                      <p class="invalid-feedback"> {{ $message }}</p>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">Price</label>
                      <input type="number" value="{{ old('price') }}" class="form-control @error('price') is-invalid  @enderror" id="price" name="price" min="0">
                      @error('price')
                      <p class="invalid-feedback"> {{ $message }}</p>
                      @enderror
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">Image</label>
                      <input type="file" class="form-control" id="product_image" name="product_image">
                    </div>

                    <div class="mb-3">
                      <label for="name" class="form-label">Type</label>
                      <select name="product_type" id="product_type" class="form-control">
                        <option value="male" {{ old('product_type') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('product_type') == 'female' ? 'selected' : '' }}>Female</option>
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
