<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
            font-size: 12px;
            margin: 0;
            padding: 0;
            width: 57mm;
            font-family: 'Arial', sans-serif;
        }

        h1,
        p {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .table {
            width: 100%;
            margin-top: 10px;

        }

        /* .table,
        .table th,
        .table td {
            border: 1px solid black;
            padding: 2px; */
        /* } */

        .table th,
        .table td {
            font-size: 12px;
        }
    </style>
</head>

<body>

    <h1>{{ $invoice->no_faktur }}</h1>
    <p>{{ $invoice->tanggal }}</p>
    <br />
    <br />
    <p>Invoice Number: {{ $invoice->id }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Barang</th>
                <th>Quantity</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->det_jual as $detail)
                <tr>
                    <td>{{ $detail->barang->nama }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->harga_jual }}</td>
                    <td>{{ $detail->harga_beli }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        
    </script>

</body>

</html>
