<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
        text-align: center;
    }

    table th, table td {
        border: 1px solid #000;
        padding: 5px;
    }
</style>
<body>
    <h4>{{ $title }} - {{ now()->translatedFormat('d F Y H:i') }} WIB</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Item</th>
                <th>Lokasi Item</th>
                <th>Jumlah</th>
                <th>Satuan / Unit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($model as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->item->name }}</td>
                    <td>{{ $row->warehouse->name }}</td>
                    <td>{{ $row::liveStock($row->item_id, $row->warehouse_id) }}</td>
                    <td>{{ $row->item->unit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>