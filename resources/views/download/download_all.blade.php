<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        tr td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <table>
        <tbody>
            @foreach ($chunked as $arr)
                <tr>
                    @foreach($arr as $data)
                        <td>
                            <table>
                                <tr><td>Title: {{ $data['book']['title'] }}</td></tr>
                                <tr><td>Condition: {{ $data['condition']['name'] }}</td></tr>
                                <tr><td>Publication: {{ date('d.m.Y.', strtotime($data['publication_date'])) }}</td></tr>
                            </table>
                        </td>
                        <td><img src="data:image/svg;base64, {{ base64_encode(QrCode::format('svg')->size(120)->generate(config('app.url').'/books/qrcode/read/'.$data['id'])) }}"></td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

