<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .bill-container {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            max-width: 100%;
            margin: 0 auto;
        }
        .bill-header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .bill-header .logo {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: left;
        }
        .bill-header .info {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            text-align: right;
        }
        .bill-header h3 {
            margin: 0;
            font-size: 18px;
            color: #007bff;
        }
        .bill-header p {
            margin: 4px 0;
            font-size: 12px;
            color: #6c757d;
        }
        .customer-details {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .customer-details div {
            flex: 1;
            min-width: 45%;
        }
        .customer-details p {
            margin: 4px 0;
            font-size: 12px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        .table td {
            background-color: #f8f9fa;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .footer div {
            flex: 1;
            min-width: 45%;
        }
        .footer p {
            margin: 4px 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <!-- Bill Header -->
        <div class="bill-header">
            <div class="logo">
                <img src="{{ public_path('assets/images/logos/clothexlogo.jfif') }}" style="max-width: 120px;" alt="Logo">
            </div>
            <div class="info">
                <h3>CLOTHEX MENS WEAR</h3>
                <p>Dattanager Jambulwadi Road, Katraj</p>
                <p>+91 9960466505</p>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="customer-details">
            <div>
                <p><strong>Name:</strong> {{ $data->name }}</p>
                <p><strong>Mobile:</strong> {{ $data->mobile }}</p>
            </div>
            <div style="text-align: right;">
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($data->bill_date)->format('d/m/Y') }}</p>
                <p><strong>Bill No:</strong> {{ $data->id }}</p>
            </div>
        </div>

        <!-- Product Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Amt</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php $sr_no = 1; @endphp
                @foreach($data->purchases as $p)
                <tr>
                    <td>{{ $sr_no++ }}</td>
                    <td>{{ $p->product->name ?? 'N/A' }}</td>
                    <td>{{ $p->quantity ?? '0' }}</td>
                    <td>{{ number_format($p->price ?? 0, 2) }}</td>
                    <td>{{ number_format($p->total_amt ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Footer Details -->
        <div class="footer">
            <div>
                <p><strong>Discount (Amt):</strong> {{ number_format($data->payment->disc_amt ?? 0, 2) }}</p>
                <p><strong>Discount (%):</strong> {{ $data->payment->disc_percentage ?? 0 }}%</p>
            </div>
            <div style="text-align: right;">
                <p><strong>Grand Total:</strong> {{ number_format($data->payment->grand_total ?? 0, 2) }}</p>
                <p><strong>Total Discount:</strong> {{ number_format($data->payment->disc_amt ?? 0, 2) }}</p>
                <p><strong>Total Paid:</strong> {{ number_format($data->payment->total_paid_amt ?? 0, 2) }}</p>
            </div>
        </div> 
    </div>
</body>
</html>
