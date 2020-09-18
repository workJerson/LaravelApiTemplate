<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin: 10px;
            padding: 0px;
        }
        p, h1 {
            margin: 0px;
            padding: 0px;
        }
        .page-break {
            page-break-after: always;
        }
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }
        th {
            background-color: #dddddd;
            border: 1px solid #000;
            text-align: center;
            padding: 4px;
        }
        td {
            border: 1px solid #000;
            text-align: center;
            margin-left: 3px;
            margin-right: 3px;
        }
        hr {
            margin: 5px 5px;
        }
    </style>
</head>
<body>
@foreach ($transactions as $transaction)
    <hr style= "border: 3px solid red">
    <hr style= "border: 3px solid blue" >
    <center>
        <h1>Statement of Account</h1>
        <p>{{ $transaction->hub->name }} Hub - "{{ $transaction->program->name }} Program"</p>
        <p>{{ $transaction->student->course->name}}</p>
    </center>
    <p>To: {{ $transaction->student->user->userDetail->full_name }}</p>
    <p>{{ $transaction->student->user->userDetail->address }}</p>
    <p>{{ $transaction->hub->name }} Hub</p>
    <p>Table 1. Schedule of Payments</p>
    <table>
        <tr>
            <th>Transactions</th>
            <th>Transaction Date</th>
            <th>OR No.</th>
            <th>Registration Fee</th>
            <th>Food</th>
            <th>Payment Made</th>
        </tr>
        @foreach ($transaction->transactionDetails as $transactionDetail)
        <tr>
            <td>{{ $transactionDetail->type }}</td>
            <td>{{ $transactionDetail->transaction_date }}</td>
            <td>{{ $transactionDetail->session_cost ?? '--' }}</td>
            <td>{{ $transactionDetail->registration_fee ?? '0.00' }}</td>
            <td>{{ $transactionDetail->food_fee ?? '0.00' }}</td>
            <td>{{ $transactionDetail->food_fee  ?? '0.00'}}</td>
        </tr>
        @endforeach
        <tr>
            <td>TOTAL:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>123123.12321</td>
        </tr>
    </table>
    <p>*LEGEND: Registration fee less Allocation for Food equals Total Payments entered to your account.</p>
    <p>Training/Seminar Fees (Program Cost)</p>
    <p>Final Validation/Exit Conference</p>
    <p>Conferment/Graduation Ceremonies</p>
    <p>TOTAL PROGRAM COST</p>
    <p>Less: Total Payments made as of to date</p>
    <center>
        <p>TOTAL ACCOUNT BALANCE</p>
        <p>If you have any questions/queries please contact us at:</p>
        <p>Smart: +63930-909-8564</p>
        <p>Globe: +63916-331-8962</p>
        <p>Email: jameslouiebaldoza@gmail.com</p>
    </center>
    <div class="page-break"></div>
@endforeach
</body>
</html>