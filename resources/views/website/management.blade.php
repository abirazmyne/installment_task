<!-- resources/views/website/management.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records Management</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1>Records for Member ID: {{ request()->route('member_id') }}</h1>

    @if($records->isEmpty())
        <p>No records found for this member.</p>
    @else
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Installment Amount</th>
                <th>Amount</th>
                <th>Penalty Amount</th>
                <th>Payment Pending Amount</th>
                <th>Paid</th>
                <th>Due Date</th>
                <th>Payment Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->email }}</td>
                    <td>{{ $record->phone }}</td>
                    <td>{{ $record->address }}</td>
                    <td>{{ $record->installment_amount }}</td>
                    <td>{{ $record->amount }}</td>
                    <td>{{ $record->penalty_amount }}</td>
                    <td>{{ $record->payment_pending_amount }}</td>
                    <td>{{ $record->paid ? 'Yes' : 'No' }}</td>
              
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
