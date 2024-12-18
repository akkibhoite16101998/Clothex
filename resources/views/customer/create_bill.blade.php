@extends('layout.main_wrapper')
@section('main')
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
<div class="container-fluid">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Create Bill</h5>
        <div class="card">
          <div class="card-body">
            <form action="{{ route('bills.create_coustmer_bill') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="" class="form-label">Coustmer Name</label>
                        <input type="text" value="" class="form-control" name="coustmer_name"  required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="" class="form-label">Mobile No.</label>
                        <input type="number" value="" class="form-control" name="mobile_no"  required>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="" class="form-label">Bill Date</label>
                        <input type="date" value="" class="form-control" name="bill_date">
                    </div>
                </div>
                
                <div class="row productRow" id="productRowTemplate">
                    <div class="mb-3 col-md-4">
                        <label for="name" class="form-label">Product Type</label>
                        <select name="product_type[]" class="form-control" required>
                            <option value="">-- Select Product--</option>
                            @foreach ($product_type as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" value="" class="form-control quantity" name="quantity[]" min="1" required>
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" value="" class="form-control price" name="price[]" min="1" required>
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="total" class="form-label">Total</label>
                        <input type="number" value="" class="form-control total" name="total[]" readonly>
                    </div>

                    <div class="mb-3 col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-primary add-more-btn"><i class="ti ti-plus"></i></button>
                        <button type="button" class="btn btn-danger remove-btn"><i class="ti ti-minus"></i></button>
                    </div>
                </div>

                <!-- Payment Mode Section -->
                <div id="paymentSection">
                <div class="row mt-3">
                    <div class="mb-6 col-md-6">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="payment_mode" class="form-label">Payment Mode</label>
                            <select name="payment_mode" class="form-control" id="paymentMode" required>
                                <option value="cash">Cash</option>
                                <option value="online">Online</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-4" id="transactionIdSection" style="display: none;">
                            <label for="transaction_id" class="form-label">Transaction Id</label>
                            <input type="text" value="" class="form-control" name="transaction_id" id="transactionId">
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="discount_percentage" class="form-label">Discount %</label>
                            <input type="number" value="" class="form-control discount-percentage" name="discount_percentage" min="0">
                        </div>
                    </div>
                    </div>

                    <div class="mb-6 col-md-6">
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label for="discount_amt" class="form-label">Discount AMT</label>
                            <input type="number" value="" class="form-control discount-amt" name="discount_amt" readonly>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="grand_total_amt" class="form-label">Grand Total AMT</label>
                            <input type="number" value="" class="form-control grand-total-amt" name="grand_total_amt" readonly>
                        </div>

                        <div class="mb-3 col-md-4">
                            <label for="total_pay_amt" class="form-label">Pay AMT</label>
                            <input type="number" value="" class="form-control total-pay-amt" name="total_pay_amt" readonly>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success" id="submitBtn" disabled>Submit</button>
                </div>
                </div>
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productForm = document.getElementById('productForm');
    const productRowTemplate = document.getElementById('productRowTemplate');
    const paymentSection = document.getElementById('paymentSection');
    const paymentMode = document.getElementById('paymentMode');
    const transactionIdSection = document.getElementById('transactionIdSection');
    const submitBtn = document.getElementById('submitBtn');

    function updateGrandTotal() {
        let grandTotal = 0;
        productForm.querySelectorAll('.productRow').forEach(row => {
            const total = parseFloat(row.querySelector('.total').value) || 0;
            grandTotal += total;
        });
        document.querySelector('.grand-total-amt').value = grandTotal;
        updatePayAmount();
    }

    function updatePayAmount() {
        const grandTotal = parseFloat(document.querySelector('.grand-total-amt').value) || 0;
        const discountPercentage = parseFloat(document.querySelector('.discount-percentage').value) || 0;
        const discountAmt = Math.round((grandTotal * discountPercentage) / 100); // Round discount amount
        document.querySelector('.discount-amt').value = discountAmt;
        document.querySelector('.total-pay-amt').value = grandTotal - discountAmt;
    }

    function validateForm() {
        let isValid = true;
        productForm.querySelectorAll('[required]').forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
            }
        });

        if (paymentMode.value === 'online' && !document.getElementById('transactionId').value.trim()) {
            isValid = false;
        }

        submitBtn.disabled = !isValid;
    }

    productForm.addEventListener('click', function(event) {
        if (event.target.closest('.add-more-btn')) {
            const lastRow = productForm.querySelectorAll('.productRow').item(productForm.querySelectorAll('.productRow').length - 1);
            const productType = lastRow.querySelector('select[name="product_type[]"]').value;
            const quantity = lastRow.querySelector('input[name="quantity[]"]').value;
            const price = lastRow.querySelector('input[name="price[]"]').value;
            const total = lastRow.querySelector('input[name="total[]"]').value;

            if (productType && quantity && price && total > 1) {
                const newRow = productRowTemplate.cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                newRow.querySelector('select').value = '';
                newRow.removeAttribute('id');
                productForm.insertBefore(newRow, paymentSection);
            } else {
                alert("Please fill in all details and ensure the total is greater than 1 before adding a new row.");
            }
        }

        if (event.target.closest('.remove-btn')) {
            const row = event.target.closest('.productRow');
            if (productForm.querySelectorAll('.productRow').length > 1) {
                row.remove();
                updateGrandTotal();
            } else {
                alert("At least one row is required.");
            }
        }
    });

    productForm.addEventListener('input', function(event) {
        if (event.target.classList.contains('quantity') || event.target.classList.contains('price')) {
            if (event.target.value < 0) {
                event.target.value = 0;
            }
            const row = event.target.closest('.productRow');
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const totalField = row.querySelector('.total');
            totalField.value = quantity * price;
            updateGrandTotal();
        }

        if (event.target.classList.contains('discount-percentage')) {
            if (event.target.value < 0) {
                event.target.value = 0;
            }
            updatePayAmount();
        }

        validateForm();
    });

    paymentMode.addEventListener('change', function() {
        transactionIdSection.style.display = paymentMode.value === 'online' ? 'block' : 'none';
        validateForm();
    });

    document.getElementById('transactionId').addEventListener('input', validateForm);
});
</script>
<!--- this script use for if user select product so populate this product value in price input 
its working code in this project client want enter price so hide this script bt akshay bhoite
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const productForm = document.getElementById('productForm');
    const productRowTemplate = document.getElementById('productRowTemplate');
    const paymentSection = document.getElementById('paymentSection');
    const paymentMode = document.getElementById('paymentMode');
    const transactionIdSection = document.getElementById('transactionIdSection');
    const submitBtn = document.getElementById('submitBtn');

    // Map of product types and their prices
    const productPrices = {
        @foreach ($product_type as $type)
            "{{ $type->id }}": {{ $type->price }}, // Assuming your product type has a price property
        @endforeach
    };

    function updateGrandTotal() {
        let grandTotal = 0;
        productForm.querySelectorAll('.productRow').forEach(row => {
            const total = parseFloat(row.querySelector('.total').value) || 0;
            grandTotal += total;
        });
        document.querySelector('.grand-total-amt').value = grandTotal;
        updatePayAmount();
    }

    function updatePayAmount() {
        const grandTotal = parseFloat(document.querySelector('.grand-total-amt').value) || 0;
        const discountPercentage = parseFloat(document.querySelector('.discount-percentage').value) || 0;
        const discountAmt = Math.round((grandTotal * discountPercentage) / 100); // Round discount amount
        document.querySelector('.discount-amt').value = discountAmt;
        document.querySelector('.total-pay-amt').value = grandTotal - discountAmt;
    }

    function validateForm() {
        let isValid = true;
        productForm.querySelectorAll('[required]').forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
            }
        });

        if (paymentMode.value === 'online' && !document.getElementById('transactionId').value.trim()) {
            isValid = false;
        }

        submitBtn.disabled = !isValid;
    }

    productForm.addEventListener('click', function(event) {
        if (event.target.closest('.add-more-btn')) {
            const lastRow = productForm.querySelectorAll('.productRow').item(productForm.querySelectorAll('.productRow').length - 1);
            const productType = lastRow.querySelector('select[name="product_type[]"]').value;
            const quantity = lastRow.querySelector('input[name="quantity[]"]').value;
            const price = lastRow.querySelector('input[name="price[]"]').value;
            const total = lastRow.querySelector('input[name="total[]"]').value;

            if (productType && quantity && price && total > 1) {
                const newRow = productRowTemplate.cloneNode(true);
                newRow.querySelectorAll('input').forEach(input => input.value = '');
                newRow.querySelector('select').value = '';
                newRow.removeAttribute('id');
                productForm.insertBefore(newRow, paymentSection);
            } else {
                alert("Please fill in all details and ensure the total is greater than 1 before adding a new row.");
            }
        }

        if (event.target.closest('.remove-btn')) {
            const row = event.target.closest('.productRow');
            if (productForm.querySelectorAll('.productRow').length > 1) {
                row.remove();
                updateGrandTotal();
            } else {
                alert("At least one row is required.");
            }
        }
    });

    productForm.addEventListener('input', function(event) {
        if (event.target.classList.contains('quantity') || event.target.classList.contains('price')) {
            if (event.target.value < 0) {
                event.target.value = 0;
            }
            const row = event.target.closest('.productRow');
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const totalField = row.querySelector('.total');
            totalField.value = quantity * price;
            updateGrandTotal();
        }

        if (event.target.classList.contains('discount-percentage')) {
            if (event.target.value < 0) {
                event.target.value = 0;
            }
            updatePayAmount();
        }

        validateForm();
    });

    productForm.addEventListener('change', function(event) {
        if (event.target.name === 'product_type[]') {
            const row = event.target.closest('.productRow');
            const selectedProductId = event.target.value;
            const priceInput = row.querySelector('.price');
            priceInput.value = productPrices[selectedProductId] || 0; // Set the price based on the product type
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            row.querySelector('.total').value = (priceInput.value * quantity).toFixed(2); // Update total
            updateGrandTotal();
        }
    });

    paymentMode.addEventListener('change', function() {
        transactionIdSection.style.display = paymentMode.value === 'online' ? 'block' : 'none';
        validateForm();
    });

    document.getElementById('transactionId').addEventListener('input', validateForm);
});

</script>-->
@endsection
