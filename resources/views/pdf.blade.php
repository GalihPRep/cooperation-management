<!DOCTYPE html>
<html>

<head>
    <title>Users List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h2>User Data Table</h2>

    <table>
        <thead>
            <tr>
                <th>Mitra</th>
                <th>Judul</th>
                <th>Tanggal tandatangan</th>
                <th>Tanggal berakhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $x)
            <tr>
                <td>@foreach($x->institutions as $y)
                    @if(!$y->bmkg)
                    <span class="badge rounded-pill bg-primary me-1 mb-1 d-inline-block">{{ $y->name }}</span>
                    @endif
                    @endforeach
                </td>
                <td>{{ $x->title }}</td>
                <td>{{ $x->signing }}</td>
                <td>{{ $x->expiry }}</td>
                <td>{{ $x->status?->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>