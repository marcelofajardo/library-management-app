@extends('layouts.main')

@section('content')
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
                        <td class="p-3">{!! QrCode::generate('http://127.0.0.1:8000/books/qrcode/read/'.$data['id']); !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>    

@endsection