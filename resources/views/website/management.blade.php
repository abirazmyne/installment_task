<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<section>
    <div class="container">
        <div class="row mt-5">

            <h1 class="mb-4">Records for Member ID: {{ request()->route('member_id') }}</h1>

            @if($records->isEmpty())
                <div class="alert alert-info" role="alert">
                    No records found for this member.
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Installment Amount</th>
                                    <th scope="col">Current Installment Amount</th>
                                    <th scope="col">Paid Amount</th>
                                    <th scope="col">Penalty Amount</th>
                                    <th scope="col">Payment Pending Amount</th>
                                    <th scope="col">Paid</th>
                                    <th scope="col">Due Date</th>
                                    <th scope="col">Payment Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($records as $record)
                                    <tr>
                                        <th scope="row">{{ $record->id }}</th>
                                        <td>{{ $record->name }}</td>
                                        <td>{{ $record->email }}</td>
                                        <td>{{ $record->phone }}</td>
                                        <td>{{ $record->address }}</td>
                                        <td>{{ number_format($record->installment_amount, 2) }}</td>
                                        <td>{{ number_format($record->installment_amount_stand_current, 2) }}</td>
                                        <td>{{ number_format($record->paid_amount, 2) }}</td>
                                        <td>{{ number_format($record->penalty_amount, 2) }}</td>
                                        <td>{{ number_format($record->payment_pending_amount, 2) }}</td>
                                        <td>{{ $record->paid ? 'Yes' : 'No' }}</td>
                                        <td>{{ $record->due_date ? $record->due_date->format('d M Y h:iA') : 'N/A' }}</td>
                                        <td>{{ $record->payment_date ? $record->payment_date->format('d M Y h:iA') : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

