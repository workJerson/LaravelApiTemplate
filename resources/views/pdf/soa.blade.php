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
            border-collapse: collapse;
            width: 100%;
            padding: 0 45px;
        }
        th {
            background-color: #dddddd;
            border: 1px solid #000;
            text-align: center;
        }
        td {
            border: 1px solid #000;
            text-align: center;
        }
        .td-left {
            text-align: left !important;
            padding-left: 2px;
        }
        hr {
            margin: 5px 5px;
        }
        .column {
            float: left;
            width: 50%;
        }

/* Clear floats after the columns */
        .container:after {
            content: "";
            display: table;
            clear: both;
            margin: 0px 5px;
        }
        .logo {
            width: 100px;
            height: 100px;
            padding: 0px 10px;
            margin-top: 15px;
        }
        .logo-container {
            padding: 0;
        }
        .hr-currency {
            margin: 0 !important;
        }
    </style>
</head>
<body>
@foreach ($transactions as $transaction)
<div class="container">
    <div class="column logo-container">
        <img src="https://i.imgur.com/moh0QKH.jpg" class="logo">
        <img src="https://i.imgur.com/moh0QKH.jpg" class="logo">
        <img src="https://i.imgur.com/NbCvADc.jpg" class="logo">
    </div>
    <div class="column">
        <p style="font-weight:bold">Republic of the Philippines</p>
        <p>Department of Interior and Local Government</p>
        <p style="font-weight:bold; color:blue">PHILIPPINE COUNCILORS LEAGUE</p>
        <p style="font-weight:bold; font-size:1.5em"">PCL LEGISLATIVE ACADEMY</p>
        <p>PCL Center & Hostel: Coastal Road, Barangay Daneil Fajardo, Las Piñas City</p>
    </div>
</div>
    <hr style= "border: 3px solid red">
    <hr style= "border: 3px solid blue" >
    <center>
        <h1>Statement of Account</h1>
        <p>{{ $transaction->hub->name }} Hub - "{{ $transaction->program->name }} Program"</p>
        <p style="font-style: italic">{{ $transaction->student->course->name}}</p>
    </center>
    <div style="width: 100%; padding: 0 60px;">
        <p>To: <span style="padding-left: 10px; font-weight:bold; font-size: 1em;">{{ $transaction->student->user->userDetail->full_name }}</span></p>
        <div style="width: 100%; padding-left: 35px; margin-bottom: 15px;">
            <p>{{ $transaction->student->user->userDetail->address }}</p>
            <p>{{ $transaction->hub->name }} Hub</p>
        </div>
        <p style="text-indent: 2em">Below is the current statement of your account. Your total amount due against the program cost is
            <span style="text-decoration:underline; font-weight:bold">
                Php @convert($transaction->program->total_price - $transaction->transactionDetails->sum('total_payment_made'))
            </span>
            , payable upon the indiciation session cost
        </p>
        <br>
        <p><span style="font-weight: bold"> Table 1.</span> <span style="font-style: italic">Schedule of Payments</span></p>
    </div>
    <table>
        <tr>
            <th>Transactions</th>
            <th>Transaction Date</th>
            <th>OR No.</th>
            <th>Registration Fee</th>
            <th>Session Cost</th>
            <th>Payment Made</th>
        </tr>
        @foreach ($transaction->transactionDetails as $transactionDetail)
        <tr>
            <td class='td-left'>{{ $transactionDetail->type }}</td>
            <td class='td-left'>{{ $transactionDetail->transaction_date }}</td>
            <td>{{ $transactionDetail->all_official_receipt }}</td>
            <td>{{ $transactionDetail->total_registration_fee }}</td>
            <td>{{ $transactionDetail->total_session_cost }}</td>
            <td>{{ $transactionDetail->total_payment_made }}</td>
        </tr>
        @endforeach
        <tr>
            <td class='td-left' style="font-weight: bold;">TOTAL:</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>@convert($transaction->transactionDetails->sum('total_payment_made'))</td>
        </tr>
    </table>
    <div class="container" style="margin: 10px 0 10px 90px;">
        <div class="column">
            <p>Training/Seminar Fees <span style="font-style: italic;">(Program Cost)</span></p>
            <p>Final Validation/Exit Conference</p>
            <p>Conferment/Graduation Ceremonies</p>
            <p style="font-weight: bold;">TOTAL PROGRAM COST</p>
            <p>Less: Total Payments made as of to date</p>
            <br>
            <p style="font-weight: bold;">TOTAL ACCOUNT BALANCE</p>
        </div>
        <div class="column" style="width: 25%; text-align: right; padding-left: 40px;">
            <p><span style="padding-right: 60px;">Php</span>  @convert($transaction->program->total_price - 10000)</p>
            <p>5,000.00</p>
            <p>5,000.00</p>
            <hr class="hr-currency">
            <p style="font-weight: bold;"><span style="padding-right: 60px;">Php</span>  @convert($transaction->program->total_price)</p>
            <p> @convert($transaction->transactionDetails->sum('total_payment_made'))</p>
            <br>
            <p style="font-weight: bold;"><span style="padding-right: 60px;">Php</span> @convert($transaction->program->total_price - $transaction->transactionDetails->sum('total_payment_made'))</p>
            <hr class="hr-currency">
        </div>
    </div>
    {{-- <p>*LEGEND: Registration fee less Allocation for Food equals Total Payments entered to your account.</p> --}}
    <center>
        <div style="margin-top: 5px">
            <p>If you have any questions/queries please contact us at:</p>
            <p>Smart: +63930-909-8564</p>
            <p>Globe: +63916-331-8962</p>
            <p>Email: jameslouiebaldoza@gmail.com</p>
        </div>
    </center>
    <div class="container" style="margin: 10px 0 0 90px; ">
        <div class="column">
            <p style="margin-bottom: 40px;">Prepared By:</p>
            <p style="font-weight: bold">JAMES LOUIE P. BALDOZA, MPA</p>
            <p style="margin-left: 20px;">Program/Accounting Coordinator</p>
        </div>
        <div class="column" style="margin-left: 30px;">
            <p style="margin-bottom: 40px;">Noted By:</p>
            <p style="font-weight: bold">DR HELARIO T. CAMINERO</p>
            <p style="margin-left: 45px;">Executive Director</p>
        </div>
    </div>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>
