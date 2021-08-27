@foreach ($lendings as $data)
    <tr height="15px">
        <td>Title:</td>
        <td>{{ $data['book_copy']['book']['title'] }}</td>
    </tr>
    <tr>
        <td>Author:</td>
        <td>{{ $data['book_copy']['book']['author']['name'] }}</td>                                </tr>
    <tr>
        <td>Publication date:</td>
        <td>{{ $data['book_copy']['publication_date']->format('d.m.Y.') }}</td>
    </tr>
    <tr>
        <td>Deadline:</td>
        <td>{{ $data['deadline']->format('d.m.Y.') }}</td>
    </tr>
    <tr height="15px"></tr>
@endforeach
