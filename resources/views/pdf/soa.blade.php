<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
@foreach ($transactions as $transaction)
    <p>Transaction {{ $transaction->id }}</p>
    <p>Hub {{ $transaction->hub->name }}</p>
    <p>Student {{ $transaction->student->user->userDetail->full_name }}</p>
    <div class="page-break"></div>
@endforeach

</body>
</html>
